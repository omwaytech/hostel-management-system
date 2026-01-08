<?php

namespace App\Http\Controllers\admin\hostelWardenBackend;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Inventory;
use App\Models\InventoryItem;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');

        $inventories = Inventory::whereHas('block', function ($query) use ($hostelId) {
            $query->where('hostel_id', $hostelId);
        })->where('is_deleted', false)->get();

        return view('admin.hostelWardenBackend.inventory.index', compact('inventories'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');

        $blocks = Block::where('hostel_id', $hostelId)
            ->where('is_deleted', 0)
            ->get();

        return view('admin.hostelWardenBackend.inventory.create', [
            'inventory' => null,
            'blocks' => $blocks
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $billNumber = $request->bill_number ?: time();
            $inventory = Inventory::create([
                'block_id' => $request->block_id,
                'type' => $request->type,
                'bill_number' => $billNumber,
                'slug' => Str::slug($request->block_id . '-' .$request->bill_number . '-' . time())
            ]);
            foreach ($request->item as $itemData) {
                InventoryItem::create([
                    'inventory_id' => $inventory->id,
                    'item_name' => $itemData['item_name'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total' => $itemData['total'],
                    'slug' => Str::slug($inventory->id . '-' .$itemData['item_name'] . '-'.$itemData['total']),
                ]);
            }
            DB::commit();
            $notification = notificationMessage('success', 'Inventory', 'stored');
            return redirect()->route('hostelWarden.inventory.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Inventory', 'stored');
            return redirect()->route('hostelWarden.inventory.index')->with($notification);
        }
    }

    public function show($slug)
    {
        //
    }

    public function edit($slug)
    {
        $inventory = Inventory::whereSlug($slug)->first();
        $hostelId = session('current_hostel_id');

        $blocks = Block::where('hostel_id', $hostelId)
            ->where('is_deleted', 0)
            ->get();

        return view('admin.hostelWardenBackend.inventory.create', compact('inventory', 'blocks'));
    }

    public function update(Request $request, $slug)
    {
        try {
            DB::beginTransaction();
            $inventory = Inventory::whereSlug($slug)->first();
            $billNumber = $request->bill_number ?: time();
            $inventory->update([
                'block_id' => $request->block_id,
                'type' => $request->type,
                'bill_number' => $billNumber,
                'slug' => Str::slug($request->block_id . '-' .$request->bill_number . '-' . time())
            ]);
            if ($request->has('item')) {
                $submittedIds = [];

                foreach ($request->item as $itemData) {
                    if (
                        empty($itemData['item_name']) &&
                        empty($itemData['quantity']) &&
                        empty($itemData['unit_price']) &&
                        empty($itemData['total'])
                    ) {
                        continue;
                    }

                    if (!empty($itemData['id'])) {
                        $item = InventoryItem::find($itemData['id']);
                        if ($item && $item->inventory_id == $inventory->id) {
                            $item->update([
                                'item_name' => $itemData['item_name'],
                                'quantity' => $itemData['quantity'],
                                'unit_price' => $itemData['unit_price'],
                                'total' => $itemData['total'],
                                'slug' => Str::slug($inventory->id . '-' .$itemData['item_name'] . '-'.$itemData['total']),
                            ]);
                            $submittedIds[] = $item->id;
                        }
                    } else {
                        $new = InventoryItem::create([
                            'inventory_id' => $inventory->id,
                            'item_name' => $itemData['item_name'],
                            'quantity' => $itemData['quantity'],
                            'unit_price' => $itemData['unit_price'],
                            'total' => $itemData['total'],
                            'slug' => Str::slug($inventory->id . '-' .$itemData['item_name'] . '-'.$itemData['total']),
                        ]);
                        $submittedIds[] = $new->id;
                    }
                }
                $existingIds = $inventory->items()->pluck('id')->toArray();
                $removedIds = array_diff($existingIds, $submittedIds);

                if (!empty($removedIds)) {
                    InventoryItem::whereIn('id', $removedIds)->update(['is_deleted' => true]);
                }
            }
            DB::commit();
            $notification = notificationMessage('success', 'Inventory', 'updated');
            return redirect()->route('hostelWarden.inventory.index')->with(key: $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Inventory', 'updated');
            return redirect()->route('hostelWarden.inventory.index')->with($notification);
        }
    }

    public function destroy($slug)
    {
        try {
            Inventory::where('slug', $slug)->update(['is_deleted' => true]);
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
