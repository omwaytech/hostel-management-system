<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\UserRequest;
use App\Mail\UserCreatedMail;
use App\Notifications\HostelAdminAdded;
use App\Notifications\NewHostelStudentAdded;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Hostel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        $users = User::whereHas('hostels', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->where('is_deleted', false)->get();

        return view('admin.hostelAdminBackend.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        return view('admin.hostelAdminBackend.user.create', [
            'user' => null,
            'roles' => $roles
        ]);
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'gender' => $request->gender,
                'contact_number' => $request->contact_number,
                'date_of_birth' => $request->date_of_birth,
                'permanent_address' => $request->permanent_address,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'slug' => Str::slug($request->name .'-'. $request->email),
            ]);

            if ($request->hasFile('photo')) {
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/userPhotos/');
                $request->file('photo')->move($path, $fileName);
                $user->photo = $fileName;
                $user->save();
            };
            if ($request->hasFile('citizenship')) {
                $originalName = $request->file('citizenship')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/userCitizenship/');
                $request->file('citizenship')->move($path, $fileName);
                $user->citizenship = $fileName;
                $user->save();
            };
            $hostel = Hostel::findOrFail($request->hostel_id);

            $hostel->users()->attach($user->id, [
                'role_id' => $request->role_id,
            ]);

            // Send email
            Mail::to($user->email)->send(new UserCreatedMail($user, $request->password, $hostel->id, $request->role_id));

            // notify super admin
            // $superAdmin = User::where('role_id', 1)->first();
            // Notification::send($superAdmin, new HostelAdminAdded($hostel, $user, 'Super Admin'));

            // // notify the new hostel admin
            // $user->notify(new HostelAdminAdded($hostel, $user, 'Hostel Admin'));

            if ($request->role_id == 2) {
                $superAdmin = User::where('role_id', 1)->first();

                Notification::send($superAdmin, new HostelAdminAdded($hostel, $user, 'Super Admin'));
                $user->notify(new HostelAdminAdded($hostel, $user, 'Hostel Admin'));
            }

            // if ($request->role_id == 4) {
            //     $superAdmin = User::where('role_id', 1)->first();

            //     // notify super admin
            //     Notification::send($superAdmin, new NewHostelStudentAdded($hostel, $user, 'Super Admin'));

            //     // notify hostel admin(s) of this hostel
            //     $hostelAdmins = $hostel->users()->wherePivot('role_id', 2)->get(); // all admins of that hostel
            //     Notification::send($hostelAdmins, new NewHostelStudentAdded($hostel, $user, 'Hostel Admin'));
            // }

            DB::commit();
            $notification = notificationMessage('success', 'User', 'stored', 'and mail sent');
            return redirect()->route('hostelAdmin.user.index')->with($notification);

        } catch (\Exception $e) {
            dd($e);
            $notification = notificationMessage('error', 'User', 'stored');
            return redirect()->route('hostelAdmin.user.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $user = User::whereSlug($slug)->first();
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        return view('admin.hostelAdminBackend.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $slug)
    {
        try {
            $user = User::whereSlug($slug)->first();
            $oldPhoto = $user->photo;
            $oldCitizenship = $user->citizenship;
            $user->update([
                'name' => $request->name,
                'gender' => $request->gender,
                'contact_number' => $request->contact_number,
                'date_of_birth' => $request->date_of_birth,
                'permanent_address' => $request->permanent_address,
            ]);
            if ($request->hasFile('photo')) {
                $oldPhotoPath = public_path('storage/images/userPhotos/' . $oldPhoto);
                if ($oldPhoto && file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/userPhotos/');
                $request->file('photo')->move($path, $fileName);

                $user->photo = $fileName;
                $user->save();
            }
            if ($request->hasFile('citizenship')) {
                $oldCitizenshipPath = public_path('storage/images/userCitizenship/' . $oldCitizenship);
                if ($oldCitizenship && file_exists($oldCitizenshipPath)) {
                    unlink($oldCitizenshipPath);
                }
                $originalName = $request->file('citizenship')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/userCitizenship/');
                $request->file('citizenship')->move($path, $fileName);

                $user->citizenship = $fileName;
                $user->save();
            }
            DB::commit();
            $notification = notificationMessage('success', 'User', 'updated');
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'User', 'updated');
            return redirect()->back()->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            User::where('slug', $slug)->update(['is_deleted' => true]);
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
