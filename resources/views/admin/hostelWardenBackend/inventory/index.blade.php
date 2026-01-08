@extends('layouts.hostelWardenBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Hostel Inventory</h1>
            <ul>
                <li><a href="{{ route('hostelWarden.inventory.index') }}" class="text-primary">Index</a></li>
                <li>Hostel Inventory</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="clearfix mr-3">
                                <a href="{{ route('hostelWarden.inventory.create') }}" class="btn btn-success">
                                    <i class="nav-icon fas fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Block</th>
                                        <th>Bill Number</th>
                                        <th>Transaction Type</th>
                                        <th>Items</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventories as $inventory)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $inventory->block->name }}</td>
                                            <td>{{ $inventory->bill_number }}</td>
                                            <td>{{ $inventory->type }}</td>
                                            <td>{{ $inventory->items->count() }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-warning mr-1"
                                                        href="{{ route('hostelWarden.inventory.edit', $inventory->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
