<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\BlockRequest;
use App\Models\Block;
use App\Models\BlockImage;
use App\Models\Facility;
use App\Models\Floor;
use App\Models\Hostel;
use App\Models\Meal;
use App\Models\Occupancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlockController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        $blocks = Block::where('hostel_id', $hostelId)
        ->where('is_deleted', 0)
        ->get();
        return view('admin.hostelAdminBackend.block.index', compact('blocks'));
    }

    public function create()
    {
        $currentHostel = getCurrentHostel();
        $users = $currentHostel?->users()->wherePivot('role_id', 3)->get() ?? collect();
        return view('admin.hostelAdminBackend.block.create', ['block' => null, 'users' => $users]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $block = Block::create([
                'token' => Str::uuid(),
                'hostel_id' => $request->hostel_id,
                'warden_id' => $request->warden_id,
                'block_number' => $request->block_number,
                'name' => $request->name,
                'description' => $request->description,
                'contact' => $request->contact,
                // 'facilities' => json_encode($request->facilities),
                'location' => $request->location,
                'no_of_floor' => $request->no_of_floor,
                'email' => $request->email,
                'map' => $request->map,
                'slug' => Str::slug($request->name),
            ]);

            if ($request->hasFile('photo')) {
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/blockPhotos/');
                $request->file('photo')->move($path, $fileName);
                $block->photo = $fileName;
                $block->save();
            };

            foreach ($request->floor as $floorData) {
                Floor::create([
                    'block_id' => $block->id,
                    'floor_number' => $floorData['floor_number'],
                    'floor_label' => $floorData['floor_label'],
                    'slug' => Str::slug($block->id . '-'. $floorData['floor_label'] .'-'. time()),
                ]);
            }

            foreach ($request->occupancy as $occupancyData) {
                Occupancy::create([
                    'block_id' => $block->id,
                    'occupancy_type' => $occupancyData['occupancy_type'],
                    'monthly_rent' => $occupancyData['monthly_rent'],
                    'slug' => Str::slug($block->id . '-'. $occupancyData['occupancy_type'] .'-'. time()),
                ]);
            }

            foreach ($request->file('image_uploads') as $index => $imageFile) {
                $originalName = $imageFile->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/blockImages');
                $imageFile->move($path, $fileName);
                BlockImage::create([
                    'block_id' => $block->id,
                    'image' => $fileName,
                    'caption' => $request->images_data[$index]['caption'],
                    'slug' => Str::slug($block->id .'-'. $request->images_data[$index]['caption'])
                ]);
            }

            foreach ($request->meals as $day => $meal) {
                Meal::create(
                    [
                        'block_id' => $block->id,
                        'day' => $day,
                        'early_morning' => $meal['early_morning'],
                        'morning' => $meal['morning'],
                        'day_meal' => $meal['day_meal'],
                        'evening' => $meal['evening'],
                    ]
                );
            }

            DB::commit();
            $notification = notificationMessage('success', 'Block', 'stored');
            return redirect()->route('hostelAdmin.block.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = notificationMessage('error', 'Block', 'stored');
            return redirect()->route('hostelAdmin.block.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $block = Block::whereSlug($slug)->first();
        $currentHostel = getCurrentHostel();
        $users = $currentHostel?->users()->wherePivot('role_id', 3)->get() ?? collect();
        $meals = Meal::where('block_id', $block->id)->get()->keyBy('day')->toArray();
        return view('admin.hostelAdminBackend.block.create', compact('block', 'users', 'meals'));
    }

    public function update(Request $request, $slug)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $block = Block::whereSlug($slug)->first();
            $oldPhoto = $block->photo;

            // $oldFacilities = json_decode($block->facilities ?? '[]', true);
            // $newFacilities = array_filter($request->facilities);

            // // Keep only old value that are still in the new submission
            // $keptOldFacilities = array_intersect($oldFacilities, $newFacilities);
            // $addedNewFacilities = array_diff($newFacilities, $oldFacilities);

            // $updatedFacilities = array_values(array_unique(array_merge($keptOldFacilities, $addedNewFacilities)));

            $block->update([
                'hostel_id' => $request->hostel_id,
                'warden_id' => $request->warden_id,
                'block_number' => $request->block_number,
                'name' => $request->name,
                'description' => $request->description,
                'contact' => $request->contact,
                // 'facilities' => json_encode($updatedFacilities),
                'location' => $request->location,
                'no_of_floor' => $request->no_of_floor,
                'email' => $request->email,
                'map' => $request->map,
                'slug' => Str::slug($request->name),
            ]);

            if ($request->hasFile('photo')) {
                $oldPhotoPath = public_path('storage/images/blockPhotos/' . $oldPhoto);
                if ($oldPhoto && file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/blockPhotos/');
                $request->file('photo')->move($path, $fileName);

                $block->photo = $fileName;
                $block->save();
            }
            //
            if ($request->has('floor')) {
                $submittedIds = [];

                foreach ($request->floor as $floorData) {
                    if (!empty($floorData['id'])) {
                        $floor = Floor::find($floorData['id']);
                        if ($floor && $floor->block_id == $block->id) {
                            $floor->update([
                                'block_id' => $block->id,
                                'floor_number' => $floorData['floor_number'],
                                'floor_label' => $floorData['floor_label'],
                                'slug' => Str::slug($block->id .'-'. $floorData['floor_label'] .'-'. time()),
                            ]);
                            $submittedIds[] = $floor->id;
                        }
                    } else {
                        $new = Floor::create([
                            'block_id' => $block->id,
                            'floor_number' => $floorData['floor_number'],
                            'floor_label' => $floorData['floor_label'],
                            'slug' => Str::slug($block->id .'-'. $floorData['floor_label'] .'-'. time()),
                        ]);
                        $submittedIds[] = $new->id;
                    }
                }
                $existingIds = $block->floors()->pluck('id')->toArray();
                $removedIds = array_diff($existingIds, $submittedIds);

                if (!empty($removedIds)) {
                    Floor::whereIn('id', $removedIds)->update(['is_deleted' => true]);
                }
            }
            //
            if ($request->has('occupancy')) {
                $submittedIds = [];

                foreach ($request->occupancy as $occupancyData) {
                    if (!empty($occupancyData['id'])) {
                        $occupancy = Occupancy::find($occupancyData['id']);
                        if ($occupancy && $occupancy->block_id == $block->id) {
                            $occupancy->update([
                                'block_id' => $block->id,
                                'occupancy_type' => $occupancyData['occupancy_type'],
                                'monthly_rent' => $occupancyData['monthly_rent'],
                                'slug' => Str::slug($block->id .'-'. $occupancyData['occupancy_type'] .'-'. time()),
                            ]);
                            $submittedIds[] = $occupancy->id;
                        }
                    } else {
                        $new = Occupancy::create([
                            'block_id' => $block->id,
                            'occupancy_type' => $occupancyData['occupancy_type'],
                            'monthly_rent' => $occupancyData['monthly_rent'],
                            'slug' => Str::slug($block->id .'-'. $occupancyData['occupancy_type'] .'-'. time()),
                        ]);
                        $submittedIds[] = $new->id;
                    }
                }
                $existingIds = $block->occupancies()->pluck('id')->toArray();
                $removedIds = array_diff($existingIds, $submittedIds);

                if (!empty($removedIds)) {
                    Occupancy::whereIn('id', $removedIds)->update(['is_deleted' => true]);
                }
            }

            // -- delete existing values --
            $existingImageIds = $block->images->pluck('id')->toArray();
            $submittedIds = collect($request->images_data ?? [])
                ->filter(fn($data) => isset($data['existing']))
                ->pluck('existing')
                ->toArray();
            $removedImageIds = array_diff($existingImageIds, $submittedIds);

            BlockImage::whereIn('id', $removedImageIds)->each(function ($image) {
                $filePath = public_path('storage/images/blockImages/' . $image->image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $image->delete();
            });

            //--- update existing values ---
            foreach ($request->images_data as $index => $data) {
                if (isset($data['existing'])) {
                    // Update existing image
                    $blockImage = BlockImage::find($data['existing']);
                    if (!$blockImage) continue;

                    // Replace image if a new one is uploaded
                    if ($request->hasFile("images_data.$index.new_image")) {
                        $newImage = $request->file("images_data.$index.new_image");
                        $fileName = time() . '-' . $newImage->getClientOriginalName();
                        $newImage->move(public_path('storage/images/blockImages'), $fileName);

                        // Delete old file
                        $oldPath = public_path('storage/images/blockImages/' . $blockImage->image);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }

                        $blockImage->image = $fileName;
                    }

                    $blockImage->caption = $data['caption'];
                    $blockImage->slug = Str::slug($block->id . '-' . $data['caption']);
                    $blockImage->save();
                }
            }

            //--- Handle newly uploaded values ---
            if ($request->hasFile('image_uploads')) {
                foreach ($request->file('image_uploads') as $index => $imageFile) {
                    if (!$imageFile) continue;

                    $fileName = time() . '-' . $imageFile->getClientOriginalName();
                    $imageFile->move(public_path('storage/images/blockImages'), $fileName);

                    // Find matching new image data using next available index
                    $data = $request->images_data[$index + count($block->images)] ?? null;
                    if ($data) {
                        BlockImage::create([
                            'block_id' => $block->id,
                            'image' => $fileName,
                            'caption' => $data['caption'],
                            'slug' => Str::slug($block->id . '-' . $data['caption']),
                        ]);
                    }
                }
            }

            foreach ($request->meals as $day => $mealData) {
                Meal::where('block_id', $block->id)
                    ->where('day', $day)
                    ->update([
                        'early_morning' => $mealData['early_morning'],
                        'morning'       => $mealData['morning'],
                        'day_meal'      => $mealData['day_meal'],
                        'evening'       => $mealData['evening'],
                    ]);
            }

            DB::commit();
            $notification = notificationMessage('success', 'Block', 'updated');
            return redirect()->route('hostelAdmin.block.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = notificationMessage('error', 'Block', 'updated');
            return redirect()->route('hostelAdmin.block.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Block::where('slug', $slug)->update(['is_deleted' => true]);
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
}
