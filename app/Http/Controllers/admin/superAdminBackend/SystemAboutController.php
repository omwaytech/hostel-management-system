<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Http\Requests\superAdminBackend\AboutRequest;
use App\Models\SystemAbout;
use App\Models\SystemValue;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SystemAboutController extends Controller
{
    public function index()
    {
        $abouts = SystemAbout::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.systemAbout.index', compact('abouts'));
    }
    public function create()
    {
        return view('admin.superAdminBackend.systemAbout.create', ['about' => null]);
    }

    public function store(AboutRequest $request)
    {
        try {
            DB::beginTransaction();
            $about = SystemAbout::create([
                'about_title' => $request->about_title,
                'about_description' => $request->about_description,
                'about_mission' => $request->about_mission,
                'about_vision' => $request->about_vision,
                'slug' => Str::slug($request->about_title),
            ]);
            if ($request->has('value') && is_array($request->value)) {
                foreach ($request->value as $key => $val) {
                    // Skip if value_title is not set
                    if (!isset($val['value_title'])) {
                        continue;
                    }

                    $filename = null;

                    if (isset($val['value_icon']) && $request->hasFile("value.$key.value_icon")) {
                        $originalName = $request->file("value.$key.value_icon")->getClientOriginalName();
                        $filename = time() . '_' . uniqid() . '_' . $originalName;
                        $path = public_path('storage/images/valueImages');
                        $request->file("value.$key.value_icon")->move($path, $filename);
                    }

                    SystemValue::create([
                        'system_about_id' => $about->id,
                        'value_title' => $val['value_title'],
                        'value_icon' => $filename,
                        'value_description' => $val['value_description'] ?? '',
                        'slug' => Str::slug($val['value_title'] . '-' . time()),
                    ]);
                }
            }
            DB::commit();
            $notification = notificationMessage('success', 'About', 'stored');
            return redirect()->route('admin.system-about.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $notification = notificationMessage('error', 'About', 'stored');
            return redirect()->route('admin.system-about.index')->with($notification);
        }
    }

    public function edit($slug)
    {
        $about = SystemAbout::whereSlug($slug)->first();
        return view('admin.superAdminBackend.systemAbout.create', compact('about'));
    }

    public function update(AboutRequest $request, $slug)
    {
        // dd($request->all());

        try {
            DB::beginTransaction();
            $about = SystemAbout::whereSlug($slug)->first();
            $about->update([
                'about_title' => $request->about_title,
                'about_description' => $request->about_description,
                'about_mission' => $request->about_mission,
                'about_vision' => $request->about_vision,
                'slug' => Str::slug($request->about_title),
            ]);
            $existingValueIds = $about->values()->pluck('id')->toArray();
            $incomingIds = [];

            if ($request->has('value') && is_array($request->value)) {
                foreach ($request->value as $key => $val) {
                    // Skip if value_title is not set
                    if (!isset($val['value_title'])) {
                        continue;
                    }

                    $filename = null;

                    if (isset($val['value_icon']) && $request->hasFile("value.$key.value_icon")) {
                        $originalName = $request->file("value.$key.value_icon")->getClientOriginalName();
                        $filename = time() . '_' . uniqid() . '_' . $originalName;
                        $path = public_path('storage/images/valueImages');
                        $request->file("value.$key.value_icon")->move($path, $filename);
                    }

                    if (isset($val['id']) && in_array($val['id'], $existingValueIds)) {
                        $value = SystemValue::find($val['id']);

                        // If a new icon is uploaded, delete the old one
                        if ($filename && $value->value_icon) {
                            $oldIconPath = public_path('storage/images/valueImages/' . $value->value_icon);
                            if (file_exists($oldIconPath)) {
                                unlink($oldIconPath);
                            }
                        }

                        $value->update([
                            'value_title' => $val['value_title'],
                            'value_description' => $val['value_description'] ?? '',
                            'value_icon' => $filename ?? $value->value_icon,
                        ]);
                        $incomingIds[] = $val['id'];
                    } else {
                        $newValue = SystemValue::create([
                            'system_about_id' => $about->id,
                            'value_title' => $val['value_title'],
                            'value_description' => $val['value_description'] ?? '',
                            'value_icon' => $filename,
                            'slug' => Str::slug($val['value_title'] . '-' . time()),
                        ]);
                        $incomingIds[] = $newValue->id;
                    }
                }
            }

            if (!empty($incomingIds)) {
                $about->values()->whereNotIn('id', $incomingIds)->update(['is_deleted' => 1]);
            } else {
                // If no incoming IDs, mark all existing values as deleted
                $about->values()->update(['is_deleted' => 1]);
            }

            DB::commit();
            $notification = notificationMessage('success', 'About', 'updated');
            return redirect()->route('admin.system-about.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $notification = notificationMessage('error', 'About', 'updated');
            return redirect()->route('admin.system-about.index')->with($notification);
        }
    }
    public function destroy($slug)
    {
        try {
            SystemAbout::where('slug', $slug)->update(['is_deleted' => true]);
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
