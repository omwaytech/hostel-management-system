<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $teams = Team::where('hostel_id', $hostelId)->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.team.index', compact('teams'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.team.create', ['team' => null, 'hostelId' => $hostelId]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $team = Team::create([
                'hostel_id' => $request->hostel_id,
                'member_name' => $request->member_name,
                'member_designation' => $request->member_designation,
                'member_description' => $request->member_description,
                'slug' => Str::slug($request->member_name . '-' . time()),
            ]);

            if ($request->hasFile('member_image')) {
                $originalName = $request->file('member_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/memberImages/');
                $request->file('member_image')->move($path, $fileName);

                $team->member_image = $fileName;
                $team->save();
            }

            DB::commit();
            $notification = notificationMessage('success', 'Team', 'stored');
            return redirect()->route('hostelAdmin.team.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Team', 'stored');
            return redirect()->route('hostelAdmin.team.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $team = Team::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.team.create', compact('team', 'hostelId'));
    }

    public function publish(Request $request, $slug)
    {
        Team::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function update(Request $request, $slug)
    {
        try {
            DB::beginTransaction();
            $team = Team::whereSlug($slug)->first();
            $team->update([
                'member_name' => $request->member_name,
                'member_designation' => $request->member_designation,
                'member_description' => $request->member_description,
            ]);

            if ($request->hasFile('member_image')) {
                if ($team->member_image) {
                    $oldImagePath = public_path('storage/images/memberImages/' . $team->member_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $originalName = $request->file('member_image')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/memberImages/');
                $request->file('member_image')->move($path, $fileName);

                $team->member_image = $fileName;
                $team->save();
            }

            DB::commit();
            $notification = notificationMessage('success', 'Team', 'updated');
            return redirect()->route('hostelAdmin.team.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Team', 'updated');
            return redirect()->route('hostelAdmin.team.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Team::where('slug', $slug)->update(['is_deleted' => true]);
            return response()->json([
                'success' => true,
                'message' => 'Successfully removed.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
