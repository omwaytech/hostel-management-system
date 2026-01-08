<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\StaffRequest;
use App\Models\Block;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        $staffs = Staff::whereHas('block', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->where('is_deleted', false)->get();

        return view('admin.hostelAdminBackend.staff.index', compact('staffs'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');

        $blocks = Block::where('hostel_id', $hostelId)
            ->where('is_deleted', 0)
            ->get();

        return view('admin.hostelAdminBackend.staff.create', [
            'staff' => null,
            'blocks' => $blocks
        ]);
    }

    public function store(StaffRequest $request)
    {
        try {
            $staff = Staff::create([
                'block_id' => $request->block_id,
                'full_name' => $request->full_name,
                'role' => $request->role,
                'contact_number' => $request->contact_number,
                'basic_salary' => $request->basic_salary,
                'join_date' => $request->join_date,
                'leave_date' => $request->leave_date,
                'pan_number' => $request->pan_number,
                'bank_account_number' => $request->bank_account_number,
                'income_tax' => $request->income_tax,
                'cit' => $request->cit,
                'ssf' => $request->ssf,
                'slug' => Str::slug($request->block_id .'-'. $request->full_name .'-'. $request->role)
            ]);
            if ($request->hasFile('photo')) {
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/staffPhotos/');
                $request->file('photo')->move($path, $fileName);
                $staff->photo = $fileName;
                $staff->save();
            };
            if ($request->hasFile('citizenship')) {
                $originalName = $request->file('citizenship')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/staffCitizenship/');
                $request->file('citizenship')->move($path, $fileName);
                $staff->citizenship = $fileName;
                $staff->save();
            };
            $notification = notificationMessage('success', 'Staff', 'stored');
            return redirect()->route('hostelAdmin.staff.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            $notification = notificationMessage('error', 'Staff', 'stored');
            return redirect()->route('hostelAdmin.staff.index')->with($notification);
        }
    }

    public function show($slug)
    {
        try{
            $currentHostelId = session('current_hostel_id');

            $staff = Staff::whereHas('block.hostel', function ($q) use ($currentHostelId) {
                    $q->where('id', $currentHostelId);
                })
                ->whereSlug($slug)
                ->firstOrFail();
            return view('admin.hostelAdminBackend.staff.show', compact('staff'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->with('error', 'Unauthorized access to staff profile.');
        }
    }

    public function edit($slug)
    {
        $staff = Staff::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');

        $blocks = Block::with(['floors.rooms.beds'])
            ->where('hostel_id', $hostelId)
            ->where('is_deleted', 0)
            ->get();
        return view('admin.hostelAdminBackend.staff.create', compact('staff', 'blocks'));
    }

    public function update(StaffRequest $request, $slug)
    {
        try {
            $staff = Staff::whereSlug($slug)->first();
            $oldPhoto = $staff->photo;
            $oldCitizenship = $staff->citizenship;
            $staff->update([
                'block_id' => $request->block_id,
                'full_name' => $request->full_name,
                'role' => $request->role,
                'contact_number' => $request->contact_number,
                'basic_salary' => $request->basic_salary,
                'join_date' => $request->join_date,
                'leave_date' => $request->leave_date,
                'pan_number' => $request->pan_number,
                'bank_account_number' => $request->bank_account_number,
                'income_tax' => $request->income_tax,
                'cit' => $request->cit,
                'ssf' => $request->ssf,
                'slug' => Str::slug($request->block_id .'-'. $request->full_name .'-'. $request->role)
            ]);
            if ($request->hasFile('photo')) {
                $oldPhotoPath = public_path('storage/images/staffPhotos/' . $oldPhoto);
                if ($oldPhoto && file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/staffPhotos/');
                $request->file('photo')->move($path, $fileName);

                $staff->photo = $fileName;
                $staff->save();
            }

            if ($request->hasFile('citizenship')) {
                $oldCitizenshipPath = public_path('storage/images/staffCitizenship/' . $oldCitizenship);
                if ($oldCitizenship && file_exists($oldCitizenshipPath)) {
                    unlink($oldCitizenshipPath);
                }
                $originalName = $request->file('citizenship')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/staffCitizenship/');
                $request->file('citizenship')->move($path, $fileName);

                $staff->citizenship = $fileName;
                $staff->save();
            }
            $notification = notificationMessage('success', 'Staff', 'updated');
            return redirect()->route('hostelAdmin.staff.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            $notification = notificationMessage('error', 'Staff', 'updated');
            return redirect()->route('hostelAdmin.staff.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Staff::where('slug', $slug)->update(['is_deleted' => true]);
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
