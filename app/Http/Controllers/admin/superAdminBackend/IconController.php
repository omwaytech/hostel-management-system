<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Models\Icon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IconController extends Controller
{
    public function index()
    {
        $icons = Icon::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.icon.index', compact('icons'));
    }

    public function create()
    {
        return view('admin.superAdminBackend.icon.create');
    }
    public function store(Request $request)
    {
    try {
            foreach ($request->icon as $day => $data) {
                $iconPath = null;
                if (isset($data['icon_path']) && $request->hasFile("icon.$day.icon_path")) {
                    $originalName = $request->file("icon.$day.icon_path")->getClientOriginalName();
                    $iconPath = time() . '_' . $originalName;
                    $path = public_path('storage/images/icons');
                    $request->file("icon.$day.icon_path")->move($path, $iconPath);;
                }

                if(isset($data['icon_name']) && $data['icon_name']) {
                    Icon::create([
                        'icon_name' => $data['icon_name'],
                        'icon_path' => $iconPath,
                        'slug' => Str::slug($data['icon_name'] . '-' . time())
                    ]);
                }
            }
            $notification = notificationMessage('success', 'Icon', 'created');
            return redirect()->route('admin.icon.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Icon', 'created');
            return redirect()->route('admin.icon.index')->with($notification);
        }
    }

    public function publish(Request $request, $slug)
    {
        Icon::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function edit($slug)
    {
        $icon = Icon::where('slug', $slug)->first();
        return view('admin.superAdminBackend.icon.edit', compact('icon'));
    }

    public function update(Request $request, $slug)
    {
        try {
            $icon = Icon::where('slug', $slug)->first();
            $icon->update([
                'icon_name' => $request->icon_name,
                'slug' => Str::slug($request->icon_name . '-' . time())
            ]);

            if ($request->hasFile('icon_path')) {
                if ($icon->icon_path) {
                    $oldImagePath = public_path('storage/images/icons/' . $icon->icon_path);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $originalName = $request->file('icon_path')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/icons/');
                $request->file('icon_path')->move($path, $fileName);

                $icon->icon_path = $fileName;
                $icon->save();
            }

            $notification = notificationMessage('success', 'Icon', 'updated');
            return redirect()->route('admin.icon.index')->with($notification);
        } catch (\Exception $e) {
            $notification = notificationMessage('error', 'Icon', 'updated');
            return redirect()->route('admin.icon.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Icon::where('slug', $slug)->update(['is_deleted' => true]);
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
