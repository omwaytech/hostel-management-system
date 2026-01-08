<?php

namespace App\Http\Controllers\frontend\hostelPortal;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function gallery()
    {
        $hostel = session('active_hostel');

        // Fetch albums with their images for the current hostel
        $albums = Album::where('hostel_id', $hostel->id)
            ->with('images')
            ->get()
            ->map(function ($album) {
                return [
                    'id' => $album->id,
                    'title' => $album->album_name,
                    'photoCount' => $album->images->count(),
                    'coverImage' => asset('storage/images/albumImages/' . $album->album_cover),
                    'photos' => $album->images->map(function ($image) {
                        return asset('storage/images/albumImages/' . $image->gallery_image);
                    })->toArray()
                ];
            });

        return view('frontend.hostelPortal.gallery', compact('hostel', 'albums'));
    }
}
