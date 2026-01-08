<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CkEditorImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        try {
            if ($request->hasFile('upload')) {
                $originName = $request->file('upload')->getClientOriginalName();
                $filename = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('upload')->getClientOriginalExtension();
                $fileName = $filename . '_' . time() . '.' . $extension;
                $request->file('upload')->move(public_path('storage/ckeditor'), $fileName);
            }
            return response()->json(['url' => asset('storage/ckeditor' . '/' . $fileName)]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
