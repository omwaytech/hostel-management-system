<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Http\Requests\superAdminBackend\HostelRequest;
use App\Models\Amenity;
use App\Models\Block;
use App\Models\Hostel;
use App\Models\HostelImage;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::where('is_deleted', false)->get();
        return view('admin.superAdminBackend.hostel.index', compact('hostels'));
    }

    public function create()
    {
        $hostelAdmins = User::where('role_id', 2)->get();
        $amenities = Amenity::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.hostel.create',
        [
            'hostel' => null,
            'hostelAdmins' => $hostelAdmins,
            'amenities' => $amenities
        ]);
    }

    public function store(HostelRequest $request)
    {
        // dd($request->all());
        try {
            $hostel = Hostel::create([
                'token' => Str::uuid(),
                'name' => $request->name,
                'description' => $request->description,
                'contact' => $request->contact,
                'location' => $request->location,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'email' => $request->email,
                'type' => $request->type,
                'slug' => Str::slug($request->name),
            ]);
            if ($request->hasFile('logo')) {
                $originalName = $request->file('logo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/hostelLogos/');
                $request->file('logo')->move($path, $fileName);
                $hostel->logo = $fileName;
                $hostel->save();
            };

            foreach ($request->file('image_uploads') as $index => $imageFile) {
                $originalName = $imageFile->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/hostelImages');
                $imageFile->move($path, $fileName);
                HostelImage::create([
                    'hostel_id' => $hostel->id,
                    'image' => $fileName,
                    'caption' => $request->images_data[$index]['caption'],
                    'slug' => Str::slug($hostel->id .'-'. $request->images_data[$index]['caption'])
                ]);
            }

            $hostel->amenities()->sync($request->amenities ?? []);

            Block::create([
                'token' => Str::uuid(),
                'hostel_id' => $hostel->id,
                'block_number' => 1,
                'name' => $request->name,
                'description' => $request->description,
                'contact' => $request->contact,
                'location'=> $request->location,
                'email' => $request->email,
                'slug' => Str::slug($request->name),
            ]);

            $notification = notificationMessage('success', 'Hostel', 'stored');
            return redirect()->route('admin.hostel.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            $notification = notificationMessage('error', 'Hostel', 'stored');
            return redirect()->route('admin.hostel.index')->with($notification);
        }
    }

    public function show($token)
    {
        $hostel = Hostel::where('token', $token)->firstOrFail();

        session(['current_hostel_id' => $hostel->id]);

        return redirect()->route('hostelAdmin.dashboard', ['token' => $token]);
    }

    public function edit($slug)
    {
        $hostel = Hostel::whereSlug($slug)->first();
        $amenities = Amenity::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.hostel.create', compact('hostel', 'amenities'));
    }

    public function update(HostelRequest $request, $slug)
    {
        // dd($request->all());
        try {
            $hostel = Hostel::whereSlug($slug)->first();
            $oldLogo = $hostel->logo;

            $hostel->update([
                'token' => Str::uuid(),
                'name' => $request->name,
                'description' => $request->description,
                'contact' => $request->contact,
                'location' => $request->location,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'email' => $request->email,
                'type' => $request->type,
                'slug' => Str::slug($request->name),
            ]);

            if ($request->hasFile('logo')) {
                $oldLogoPath = public_path('storage/images/hostelLogos/' . $oldLogo);
                if ($oldLogo && file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
                $originalName = $request->file('logo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/hostelLogos/');
                $request->file('logo')->move($path, $fileName);

                $hostel->logo = $fileName;
                $hostel->save();
            }

            // -- delete existing values --
            $existingImageIds = $hostel->images->pluck('id')->toArray();
            $submittedIds = collect($request->images_data ?? [])
                ->filter(fn($data) => isset($data['existing']))
                ->pluck('existing')
                ->toArray();
            $removedImageIds = array_diff($existingImageIds, $submittedIds);

            HostelImage::whereIn('id', $removedImageIds)->each(function ($image) {
                $filePath = public_path('storage/images/hostelImages/' . $image->image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $image->delete();
            });

            //--- update existing values ---
            foreach ($request->images_data as $index => $data) {
                if (isset($data['existing'])) {
                    // Update existing image
                    $hostelImage = HostelImage::find($data['existing']);
                    if (!$hostelImage) continue;

                    // Replace image if a new one is uploaded
                    if ($request->hasFile("images_data.$index.new_image")) {
                        $newImage = $request->file("images_data.$index.new_image");
                        $fileName = time() . '-' . $newImage->getClientOriginalName();
                        $newImage->move(public_path('storage/images/hostelImages'), $fileName);

                        // Delete old file
                        $oldPath = public_path('storage/images/hostelImages/' . $hostelImage->image);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }

                        $hostelImage->image = $fileName;
                    }

                    $hostelImage->caption = $data['caption'];
                    $hostelImage->slug = Str::slug($hostel->id . '-' . $data['caption']);
                    $hostelImage->save();
                }
            }

            //--- Handle newly uploaded values ---
            if ($request->hasFile('image_uploads')) {
                foreach ($request->file('image_uploads') as $index => $imageFile) {
                    if (!$imageFile) continue;

                    $fileName = time() . '-' . $imageFile->getClientOriginalName();
                    $imageFile->move(public_path('storage/images/hostelImages'), $fileName);

                    // Find matching new image data using next available index
                    $data = $request->images_data[$index + count($hostel->images)] ?? null;
                    if ($data) {
                        HostelImage::create([
                            'hostel_id' => $hostel->id,
                            'image' => $fileName,
                            'caption' => $data['caption'],
                            'slug' => Str::slug($hostel->id . '-' . $data['caption']),
                        ]);
                    }
                }
            }

            $block = Block::where('hostel_id', $hostel->id)->first();

            $block->update([
                'name' => $request->name,
                'description' => $request->description,
                'contact' => $request->contact,
                'location'=> $request->location,
                'email' => $request->email,
                'slug' => Str::slug($request->name),
            ]);

            $hostel->amenities()->sync($request->amenities ?? []);

            $notification = notificationMessage('success', 'Hostel', 'updated');
            return redirect()->route('admin.hostel.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            $notification = notificationMessage('error', 'Hostel', 'updated');
            return redirect()->route('admin.hostel.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Hostel::where('slug', $slug)->update(['is_deleted' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Successfully removed.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove !',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'A1' => 'Name *',
            'B1' => 'Contact *',
            'C1' => 'Location *',
            'D1' => 'Latitude',
            'E1' => 'Longitude',
            'F1' => 'Email *',
            'G1' => 'Type *',
            'H1' => 'Description *'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFD3D3D3');
        }

        // Add sample data
        $sheet->setCellValue('A2', 'Sample Hostel Name');
        $sheet->setCellValue('B2', '9876543210');
        $sheet->setCellValue('C2', 'Kathmandu, Nepal');
        $sheet->setCellValue('D2', '27.7172');
        $sheet->setCellValue('E2', '85.3240');
        $sheet->setCellValue('F2', 'sample@hostel.com');
        $sheet->setCellValue('G2', 'Boys');
        $sheet->setCellValue('H2', 'This is a sample hostel description.');

        // Add instructions
        $sheet->setCellValue('A4', 'Instructions:');
        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->setCellValue('A5', '1. Fields marked with * are required');
        $sheet->setCellValue('A6', '2. Type must be one of: Boys, Girls, Co-ed');
        $sheet->setCellValue('A7', '3. Email must be unique');
        $sheet->setCellValue('A8', '4. Contact should be a valid phone number');
        $sheet->setCellValue('A9', '5. Latitude format: -90 to 90 (e.g., 27.7172)');
        $sheet->setCellValue('A10', '6. Longitude format: -180 to 180 (e.g., 85.3240)');
        $sheet->setCellValue('A11', '7. Delete sample data before importing your data');

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create writer and download
        $writer = new Xlsx($spreadsheet);
        $fileName = 'hostel_import_template_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Remove header row
            array_shift($rows);

            $successCount = 0;
            $errorCount = 0;
            $errors = [];
            $detailedErrors = [];

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because we removed header and Excel rows start at 1

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $rowData = [
                    'name' => $row[0] ?? null,
                    'contact' => $row[1] ?? null,
                    'location' => $row[2] ?? null,
                    'latitude' => $row[3] ?? null,
                    'longitude' => $row[4] ?? null,
                    'email' => $row[5] ?? null,
                    'type' => $row[6] ?? null,
                    'description' => $row[7] ?? null,
                ];

                // Validate row data
                $validator = Validator::make($rowData, [
                    'name' => 'required|string|max:255',
                    'contact' => 'required|string|max:20',
                    'location' => 'required|string|max:255',
                    'latitude' => 'nullable|numeric|between:-90,90',
                    'longitude' => 'nullable|numeric|between:-180,180',
                    'email' => 'required|email|unique:hostels,email',
                    'type' => 'required|in:Boys,Girls,Co-ed',
                    'description' => 'required|string',
                ]);

                if ($validator->fails()) {
                    $errorCount++;
                    $errorMessages = $validator->errors()->all();
                    $errors[] = "Row {$rowNumber}: " . implode(', ', $errorMessages);

                    // Store detailed error for log file
                    $detailedErrors[] = [
                        'row' => $rowNumber,
                        'data' => $rowData,
                        'errors' => $errorMessages,
                        'error_type' => 'Validation Failed'
                    ];
                    continue;
                }

                try {
                    // Create hostel
                    $hostel = Hostel::create([
                        'token' => Str::uuid(),
                        'name' => $row[0],
                        'contact' => $row[1],
                        'location' => $row[2],
                        'latitude' => !empty($row[3]) ? $row[3] : null,
                        'longitude' => !empty($row[4]) ? $row[4] : null,
                        'email' => $row[5],
                        'type' => $row[6],
                        'description' => $row[7],
                        'slug' => Str::slug($row[0]),
                    ]);

                    // Create default block for the hostel
                    Block::create([
                        'token' => Str::uuid(),
                        'hostel_id' => $hostel->id,
                        'block_number' => 1,
                        'name' => $row[0],
                        'description' => $row[7],
                        'contact' => $row[1],
                        'location' => $row[2],
                        'email' => $row[5],
                        'slug' => Str::slug($row[0]),
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                    $errorMsg = "Failed to create hostel - " . $e->getMessage();
                    $errors[] = "Row {$rowNumber}: {$errorMsg}";

                    // Store detailed error for log file
                    $detailedErrors[] = [
                        'row' => $rowNumber,
                        'data' => $rowData,
                        'errors' => [$errorMsg],
                        'error_type' => 'Database Error',
                        'exception' => $e->getMessage()
                    ];
                }
            }

            // Handle errors based on count
            if ($errorCount > 5) {
                // Generate and auto-download error log file
                return $this->generateAndDownloadErrorLog($detailedErrors, $successCount, $errorCount);
            } elseif ($errorCount > 0) {
                // Display errors directly on page (5 or fewer)
                return redirect()->route('admin.hostel.index')->with([
                    'notification' => 'warning',
                    'message' => "Import completed! Success: {$successCount}, Errors: {$errorCount}",
                    'import_success' => $successCount,
                    'import_errors' => $errorCount,
                    'import_error_details' => $errors
                ]);
            } else {
                // All successful
                return redirect()->route('admin.hostel.index')->with([
                    'notification' => 'success',
                    'message' => "Import completed successfully! {$successCount} hostel(s) imported.",
                    'import_success' => $successCount
                ]);
            }

        } catch (\Exception $e) {
            return redirect()->route('admin.hostel.index')->with([
                'notification' => 'error',
                'message' => 'Import failed: ' . $e->getMessage()
            ]);
        }
    }

    private function generateAndDownloadErrorLog($detailedErrors, $successCount, $errorCount)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title
        $sheet->setCellValue('A1', 'Hostel Import Error Log');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Summary
        $sheet->setCellValue('A3', 'Import Summary:');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->setCellValue('A4', "Total Successful: {$successCount}");
        $sheet->getStyle('A4')->getFont()->getColor()->setARGB('FF006100');
        $sheet->setCellValue('A5', "Total Errors: {$errorCount}");
        $sheet->getStyle('A5')->getFont()->getColor()->setARGB('FF9C0006');
        $sheet->setCellValue('A6', "Import Date: " . date('Y-m-d H:i:s'));
        $sheet->setCellValue('A7', "Total Records Processed: " . ($successCount + $errorCount));

        // Error details header
        $sheet->setCellValue('A9', 'Excel Row');
        $sheet->setCellValue('B9', 'Name');
        $sheet->setCellValue('C9', 'Contact');
        $sheet->setCellValue('D9', 'Location');
        $sheet->setCellValue('E9', 'Email');
        $sheet->setCellValue('F9', 'Type');
        $sheet->setCellValue('G9', 'Error Type');
        $sheet->setCellValue('H9', 'Error Details');

        // Style header row
        foreach (range('A', 'H') as $col) {
            $cell = $col . '9';
            $sheet->getStyle($cell)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
            $sheet->getStyle($cell)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF0070C0');
            $sheet->getStyle($cell)->getAlignment()->setWrapText(true)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }

        // Add error details
        $currentRow = 10;
        foreach ($detailedErrors as $error) {
            $sheet->setCellValue('A' . $currentRow, $error['row']);
            $sheet->setCellValue('B' . $currentRow, $error['data']['name'] ?? 'N/A');
            $sheet->setCellValue('C' . $currentRow, $error['data']['contact'] ?? 'N/A');
            $sheet->setCellValue('D' . $currentRow, $error['data']['location'] ?? 'N/A');
            $sheet->setCellValue('E' . $currentRow, $error['data']['email'] ?? 'N/A');
            $sheet->setCellValue('F' . $currentRow, $error['data']['type'] ?? 'N/A');
            $sheet->setCellValue('G' . $currentRow, $error['error_type']);

            // Format error messages with better description
            $errorDetails = "ERRORS FOUND:\n\n";
            foreach ($error['errors'] as $idx => $errMsg) {
                $errorDetails .= ($idx + 1) . ". " . $errMsg . "\n";
            }
            $errorDetails .= "\nLOCATION: Excel Row " . $error['row'];
            $errorDetails .= "\nTIME: " . date('Y-m-d H:i:s');

            if (isset($error['exception'])) {
                $errorDetails .= "\n\nTECHNICAL DETAILS:\n" . $error['exception'];
            }

            $sheet->setCellValue('H' . $currentRow, $errorDetails);
            $sheet->getStyle('H' . $currentRow)->getAlignment()->setWrapText(true);

            // Highlight error rows with red background
            $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFC7CE');

            $currentRow++;
        }

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->getColumnDimension('H')->setWidth(60);

        // Add borders
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle('A9:H' . ($currentRow - 1))->applyFromArray($styleArray);

        // Add instructions at the bottom
        $instructionRow = $currentRow + 2;
        $sheet->setCellValue('A' . $instructionRow, 'HOW TO FIX THESE ERRORS:');
        $sheet->getStyle('A' . $instructionRow)->getFont()->setBold(true)->setSize(12);

        $instructionRow++;
        $instructions = [
            '1. Check each error detail in column H to understand what went wrong',
            '2. Open your original Excel file and navigate to the row number mentioned in column A',
            '3. Fix the data according to the error message',
            '4. Common fixes:',
            '   - Ensure all required fields (marked with *) are filled',
            '   - Verify email format is correct and unique',
            '   - Check that Type is exactly: Boys, Girls, or Co-ed (case-sensitive)',
            '   - Ensure Latitude is between -90 and 90',
            '   - Ensure Longitude is between -180 and 180',
            '   - Make sure Contact is not longer than 20 characters',
            '5. After fixing all errors, save your Excel file and import again',
        ];

        foreach ($instructions as $instruction) {
            $sheet->setCellValue('A' . $instructionRow, $instruction);
            $sheet->getStyle('A' . $instructionRow)->getAlignment()->setWrapText(true);
            $instructionRow++;
        }
        $sheet->mergeCells('A' . ($instructionRow - count($instructions)) . ':H' . ($instructionRow - 1));

        // Create file
        $fileName = 'hostel_import_errors_' . date('Y-m-d_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        // Output for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
