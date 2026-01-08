<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\RoomRequest;
use App\Models\Bed;
use App\Models\Block;
use App\Models\Floor;
use App\Models\Icon;
use App\Models\Occupancy;
use App\Models\Room;
use App\Models\RoomAmenity;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        // 1st way
        // $blocks = Block::where('hostel_id', $hostelId)
        //     ->where('is_deleted', 0)
        //     ->get();
        // $blockIds = $blocks->pluck('id');
        // $floorIds = Floor::whereIn('block_id', $blockIds)->pluck('id');
        // $rooms = Room::whereIn('floor_id', $floorIds)
        //     ->where('is_deleted', false)
        //     ->get();

        // 2nd way
        $rooms = Room::whereHas('floor.block', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->where('is_deleted', false)->get();

        return view('admin.hostelAdminBackend.room.index', compact('rooms'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');
        $blocks = Block::where('hostel_id', $hostelId)->get();
        $icons = Icon::where('is_deleted', 0)->where('is_published', 1)->get();
        return view('admin.hostelAdminBackend.room.create', [
            'room' => null,
            'blocks' => $blocks,
            'icons' => $icons,
        ]);
    }

    public function store(RoomRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $room = Room::create([
                'floor_id' => $request->floor_id,
                'occupancy_id' => $request->occupancy_id,
                'room_number' => $request->room_number,
                'room_type' => $request->room_type,
                'has_attached_bathroom' => $request->has_attached_bathroom,
                'room_size' => $request->room_size,
                'room_window_number' => $request->room_window_number,
                'room_inclusions' => json_encode($request->room_inclusions),
                'slug' => Str::slug('floor '.$request->floor_id .'room '. $request->room_number),
            ]);

            if ($request->hasFile('photo')) {
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/roomPhotos/');
                $request->file('photo')->move($path, $fileName);
                $room->photo = $fileName;
                $room->save();
            };

            foreach ($request->amenity as $day => $data) {
                if(isset($data['amenity_name']) && $data['amenity_name']) {
                    RoomAmenity::create([
                        'room_id' => $room->id,
                        'amenity_name' => $data['amenity_name'],
                        'amenity_icon' => $data['amenity_icon'],
                        'slug' => Str::slug($data['amenity_name'] . '-' . time())
                    ]);
                }
            }

            foreach ($request->bed as $bed => $bedData) {
                $bedPhoto = null;
                if (isset($bedData['bed_number']) && $request->hasFile("bed.$bed.photo")) {
                    $originalName = $request->file("bed.$bed.photo")->getClientOriginalName();
                    $bedPhoto = time() . '_' . $originalName;
                    $path = public_path('storage/images/bedPhotos');
                    $request->file("bed.$bed.photo")->move($path, $bedPhoto);;
                }
                Bed::create([
                    'room_id' => $room->id,
                    'bed_number' => $bedData['bed_number'],
                    'photo' => $bedPhoto,
                    'status' => $bedData['status'],
                    'slug' => Str::slug($room->id . '-'. $bedData['bed_number'] .'-'. time()),
                ]);
            }
            DB::commit();
            $notification = notificationMessage('success', 'Room', 'stored');
            return redirect()->route('hostelAdmin.room.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $notification = notificationMessage('error', 'Room', 'stored');
            return redirect()->route('hostelAdmin.room.index')->with($notification);
        }
    }

    public function show($slug)
    {

    }

    public function edit($slug)
    {
        $room = Room::whereSlug($slug)->first();

        $hostelId = session('current_hostel_id');

        $blocks = Block::where('hostel_id', $hostelId)->get();

        $block_id = null;
        if ($room && $room->floor) {
            $block_id = $room->floor->block_id;
        }

        $icons = Icon::where('is_deleted', 0)->where('is_published', 1)->get();

        return view('admin.hostelAdminBackend.room.create', compact('room', 'blocks', 'block_id', 'icons'));
    }
    public function getFloors($block)
    {
        $floors = Floor::where('block_id', $block)->get();

        return response()->json($floors);
    }

    public function getOccupancies($block)
    {
        $occupancies = Occupancy::where('block_id', $block)->get();

        return response()->json($occupancies);
    }

    public function update(Request $request, $slug)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $room = Room::whereSlug($slug)->first();
            $oldPhoto = $room->photo;

            // inclusions
            // Handle both JSON string and array (in case data is already stored as array)
            $oldInclusions = is_array($room->room_inclusions)
                ? $room->room_inclusions
                : json_decode($room->room_inclusions ?? '[]', true);

            $newInclusions = array_filter($request->room_inclusions ?? []);
            // Keep only old tags that are still in the new submission
            $keptOldInclusions = array_intersect($oldInclusions, $newInclusions);
            $addedNewInclusions = array_diff($newInclusions, $oldInclusions);

            $updatedInclusions = array_values(array_unique(array_merge($keptOldInclusions, $addedNewInclusions)));

            $room->update([
                'floor_id' => $request->floor_id,
                'occupancy_id' => $request->occupancy_id,
                'room_number' => $request->room_number,
                'room_type' => $request->room_type,
                'has_attached_bathroom' => $request->has_attached_bathroom,
                'room_size' => $request->room_size,
                'room_window_number' => $request->room_window_number,
                'room_inclusions' => json_encode($updatedInclusions),
                'slug' => Str::slug('floor '.$request->floor_id .'room '. $request->room_number),

            ]);

            if ($request->hasFile('photo')) {
                $oldPhotoPath = public_path('storage/images/roomPhotos/' . $oldPhoto);
                if ($oldPhoto && file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
                $originalName = $request->file('photo')->getClientOriginalName();
                $fileName = time() . '-' . $originalName;
                $path = public_path('storage/images/roomPhotos/');
                $request->file('photo')->move($path, $fileName);

                $room->photo = $fileName;
                $room->save();
            }

            $existingAmenityIds = $room->roomAmenities->pluck('id')->toArray();
            $submittedAmenityIds = [];

            foreach ($request->amenity as $amenityData) {
                if (isset($amenityData['id'])) {
                    $amenity = RoomAmenity::find($amenityData['id']);
                    if ($amenity) {
                        $submittedAmenityIds[] = $amenity->id;
                        $amenity->update([
                            'amenity_name' => $amenityData['amenity_name'],
                            'amenity_icon' => $amenityData['amenity_icon'],
                            'slug' => Str::slug( $amenityData['amenity_name'] . '-' . time()),
                        ]);
                    }
                } else {
                    if(isset($amenityData['amenity_name']) && $amenityData['amenity_name']) {
                        RoomAmenity::create([
                            'room_id' => $room->id,
                            'amenity_name' => $amenityData['amenity_name'],
                            'amenity_icon' => $amenityData['amenity_icon'],
                            'slug' => Str::slug($amenityData['amenity_name'] . '-' . time())
                        ]);
                    }
                    $submittedAmenityIds[] = $amenity->id;
                }
            }
            $toDelete = array_diff($existingAmenityIds, $submittedAmenityIds);
            if (!empty($toDelete)) {
                RoomAmenity::whereIn('id', $toDelete)->update(['is_deleted' => true]);
            }

            if ($request->has('bed')) {
                $submittedIds = [];

                foreach ($request->bed as $bed => $bedData) {
                    $bedPhoto = null;
                    if ($request->hasFile("bed.$bed.photo")) {
                        $originalName = $request->file("bed.$bed.photo")->getClientOriginalName();
                        $bedPhoto = time() . '_' . $originalName;
                        $path = public_path('storage/images/bedPhotos');
                        $request->file("bed.$bed.photo")->move($path, $bedPhoto);;
                    } elseif (isset($bedData['photo'])) {
                        $bedPhoto = $bedData['photo'];
                    }
                    if (!empty($bedData['id'])) {
                        $bed = Bed::find($bedData['id']);
                        if ($bed && $bed->room_id == $room->id) {
                            $bed->update([
                                'room_id' => $room->id,
                                'bed_number' => $bedData['bed_number'],
                                'photo' => $bedPhoto,
                                'status' => $bedData['status'],
                                'slug' => Str::slug($room->id . '-'. $bedData['bed_number'] .'-'. time()),
                            ]);
                            $submittedIds[] = $bed->id;
                        }
                    } else {
                        $new = Bed::create([
                            'room_id' => $room->id,
                            'bed_number' => $bedData['bed_number'],
                            'photo' => $bedPhoto,
                            'status' => $bedData['status'],
                            'slug' => Str::slug($room->id . '-'. $bedData['bed_number'] .'-'. time()),
                        ]);
                        $submittedIds[] = $new->id;
                    }
                }
                $existingIds = $room->beds()->pluck('id')->toArray();
                $removedIds = array_diff($existingIds, $submittedIds);

                if (!empty($removedIds)) {
                    Bed::whereIn('id', $removedIds)->update(['is_deleted' => true]);
                }
            }
            DB::commit();
            $notification = notificationMessage('success', 'Room', 'updated');
            return redirect()->route('hostelAdmin.room.index')->with($notification);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            $notification = notificationMessage('error', 'Room', 'updated');
            return redirect()->route('hostelAdmin.room.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Room::where('slug', $slug)->update(['is_deleted' => true]);
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
