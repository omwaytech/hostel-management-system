<?php

namespace App\Http\Controllers\admin\superAdminBackend;


use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Hostel;
use App\Models\PropertyList;
use App\Models\Resident;
use App\Models\Staff;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProperties = PropertyList::where('is_deleted', 0)->get();
        $totalHostels = Hostel::where('is_deleted', 0)->get();
        $totalBlocks = Block::where('is_deleted', 0)->get();
        $totalResidents = Resident::where('is_deleted', 0)->get();
        $totalStaffs = Staff::where('is_deleted', 0)->get();
        return view('admin.superAdminBackend.dashboard.index', compact('totalProperties','totalHostels', 'totalBlocks', 'totalResidents', 'totalStaffs'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show(string $id)
    {

    }

    public function edit(string $id)
    {

    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }
}
