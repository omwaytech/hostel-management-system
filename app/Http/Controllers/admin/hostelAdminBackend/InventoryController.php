<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\InventoryRequest;
use App\Models\Block;
use App\Models\Inventory;
use App\Models\InventoryItem;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    // $query = Inventory::with('block', 'items')
        //     ->whereHas('block', function ($q) use ($hostelId) {
        //         $q->where('hostel_id', $hostelId);
        //     });

        // if ($request->filled('transaction_type')) {
        //     $query->where('type', $request->transaction_type);
        // }

        // if ($request->filled('start_date')) {
        //     $query->whereDate('created_at', '>=', $request->start_date);
        // }

        // if ($request->filled('end_date')) {
        //     $query->whereDate('created_at', '<=', $request->end_date);
        // }

        // $inventories = $query->latest()->get();

    public function index(Request $request)
    {
        $hostelId = session('current_hostel_id');
        $blockId = session('current_block_id');

        $query = Inventory::with('block', 'items')
            ->whereHas('block', function ($q) use ($hostelId) {
                $q->where('hostel_id', $hostelId);
            });

        if ($blockId) {
            $query->where('block_id', $blockId);
        }

        if ($request->filled('transaction_type')) {
            $query->where('type', $request->transaction_type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $inventories = $query->where('is_deleted', 0)->get();

        return view('admin.hostelAdminBackend.inventory.index', compact('inventories'));
    }

    public function create()
    {
        $hostelId = session('current_hostel_id');

        $blocks = Block::where('hostel_id', $hostelId)
            ->where('is_deleted', 0)
            ->get();

        return view('admin.hostelAdminBackend.inventory.create', [
            'inventory' => null,
            'blocks' => $blocks
        ]);
    }

    public function store(InventoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $billNumber = $request->bill_number ?: time();
            $inventory = Inventory::create([
                'block_id' => $request->block_id,
                'type' => $request->type,
                'bill_number' => $billNumber,
                'slug' => Str::slug($request->block_id . '-' . $billNumber . '-' . time())
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
            return redirect()->route('hostelAdmin.inventory.index')->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Inventory', 'stored');
            return redirect()->route('hostelAdmin.inventory.index')->with($notification);
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

        return view('admin.hostelAdminBackend.inventory.create', compact('inventory', 'blocks'));
    }

    public function update(InventoryRequest $request, $slug)
    {
        try {
            DB::beginTransaction();
            $inventory = Inventory::whereSlug($slug)->first();
            $billNumber = $request->bill_number ?: time();
            $inventory->update([
                'block_id' => $request->block_id,
                'type' => $request->type,
                'bill_number' => $billNumber,
                'slug' => Str::slug($request->block_id . '-' .$billNumber . '-' . time())
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
            return redirect()->route('hostelAdmin.inventory.index')->with(key: $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = notificationMessage('error', 'Inventory', 'updated');
            return redirect()->route('hostelAdmin.inventory.index')->with($notification);
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
