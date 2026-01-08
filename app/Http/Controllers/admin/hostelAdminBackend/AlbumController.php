<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\AlbumRequest;
use App\Models\Album;
use App\Models\Gallery;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $albums = Album::where('hostel_id', $hostelId)
        ->where('is_deleted', 0)->get();
        return view('admin.hostelAdminBackend.album.index', compact('albums'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.album.create', ['album' => null, 'hostelId' => $hostelId]);
    }

    public function store(AlbumRequest $request)
    {
        try {
            DB::beginTransaction();
            $album = Album::create([
                'hostel_id' => $request->hostel_id,
                'album_name' => $request->album_name,
                'slug' => Str::slug($request->album_name),
            ]);
            if ($request->hasFile('album_cover')) {
                $originalName = $request->file('album_cover')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/albumImages/');
                $request->file('album_cover')->move($path, $fileName);

                $album->album_cover = $fileName;
                $album->save();
            }
            foreach ($request->file('image_uploads') as $index => $imageFile) {
                $originalName = $imageFile->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/albumImages');
                $imageFile->move($path, $fileName);
                Gallery::create([
                    'album_id' => $album->id,
                    'gallery_image' => $fileName,
                    'slug' => Str::slug($album->id .'-'. $fileName)
                ]);
            }
            DB::commit();
            $notification = notificationMessage('success', 'Album', 'stored');
            return redirect()->route('hostelAdmin.album.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Album', 'stored');
            return redirect()->route('hostelAdmin.album.index')->with($notification);
        }
    }

    public function publish(Request $request, $slug)
    {
        Album::where('slug', $slug)->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(["status" => true, 'message' => "Published Successfully"]);
    }

    public function edit($slug)
    {
        $album = Album::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');
        return view('admin.hostelAdminBackend.album.create', compact('album', 'hostelId'));
    }

    public function update(AlbumRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $album = Album::whereSlug($slug)->first();
            $oldImage = $album->album_cover;
            $album->update([
                'album_name' => $request->album_name,
                'slug' => Str::slug($request->album_name),
            ]);

            if ($request->hasFile('album_cover')) {
                $fileNamePath = public_path('storage/images/albumImages/' . $oldImage);
                if ($oldImage && file_exists($fileNamePath)) {
                    unlink($fileNamePath);
                }
                $originalName = $request->file('album_cover')->getClientOriginalName();
                $fileName = time() . '_' . $originalName;
                $path = public_path('storage/images/albumImages');
                $request->file('album_cover')->move($path, $fileName);

                $album->album_cover = $fileName;
                $album->save();
            }

            //--- delete existing values ---
            $existingImageIds = $album->images->pluck('id')->toArray();
            $submittedIds = collect($request->images_data ?? [])
                ->filter(fn($data) => isset($data['existing']))
                ->pluck('existing')
                ->toArray();
            $removedImageIds = array_diff($existingImageIds, $submittedIds);
            Gallery::whereIn('id', $removedImageIds)->each(function ($image) {
                $filePath = public_path('storage/images/albumImages/' . $image->gallery_image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $image->delete();
            });

            //--- Handle newly uploaded values ---
            if ($request->hasFile('image_uploads')) {
                foreach ($request->file('image_uploads') as $index => $imageFile) {
                    if (!$imageFile) continue;

                    $fileName = time() . '-' . $imageFile->getClientOriginalName();
                    $imageFile->move(public_path('storage/images/albumImages'), $fileName);

                    // Find matching new image data using next available index
                    $data = $request->images_data[$index + count($album->images)] ?? null;
                    if ($data) {
                        Gallery::create([
                            'album_id' => $album->id,
                            'gallery_image' => $fileName,
                            'slug' => Str::slug($album->id .'-'. $fileName)
                        ]);
                    }
                }
            }

            DB::commit();
            $notification = notificationMessage('success', 'Album', 'updated');
            return redirect()->route('hostelAdmin.album.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Album', 'updated');
            return redirect()->route('hostelAdmin.album.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Album::where('slug', $slug)->update(['is_deleted' => true]);
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
