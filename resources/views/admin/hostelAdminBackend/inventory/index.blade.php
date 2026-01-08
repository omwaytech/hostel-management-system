@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Hostel Inventory</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.inventory.index') }}" class="text-primary">Index</a></li>
                <li>Hostel Inventory</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-10">
                                @php
                                    $hostelUser = Auth::user()->hostels()->withPivot('role_id')->first();
                                @endphp
                                @if (($hostelUser && $hostelUser->pivot->role_id == 2) || Auth::user()->role_id == 1)
                                    <form id="filter-form" class="form-inline mb-3" method="GET"
                                        action="{{ route('hostelAdmin.inventory.index') }}">
                                        <div class="row w-100">
                                            <div class="col-md-3">
                                                <select name="transaction_type" id="transaction_type"
                                                    class="form-control w-100">
                                                    <option value="" disabled
                                                        {{ request('transaction_type') ? '' : 'selected' }}>-- Select
                                                        Transaction --</option>
                                                    <option value="Buy"
                                                        {{ request('transaction_type') == 'Buy' ? 'selected' : '' }}>Buy
                                                    </option>
                                                    <option value="Sell"
                                                        {{ request('transaction_type') == 'Sell' ? 'selected' : '' }}>Sell
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="date" class="form-control w-100" name="start_date"
                                                    value="{{ request('start_date') }}" />
                                            </div>
                                            <div class="col-md-2">
                                                <input type="date" class="form-control w-100" name="end_date"
                                                    value="{{ request('end_date') }}" />
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                                <a href="{{ route('hostelAdmin.inventory.index') }}"
                                                    class="btn btn-secondary">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <div class="col-md-2 text-md-right text-left mt-md-0 mt-2">
                                <a href="{{ route('hostelAdmin.inventory.create') }}" class="btn btn-success mr-3">
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
                                                        href="{{ route('hostelAdmin.inventory.edit', $inventory->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a>
                                                    @php
                                                        $hostelUser = Auth::user()
                                                            ->hostels()
                                                            ->withPivot('role_id')
                                                            ->first();
                                                    @endphp

                                                    @if (($hostelUser && $hostelUser->pivot->role_id == 2) || Auth::user()->role_id == 1)
                                                        <button class="btn btn-danger delete-inventory"
                                                            data-slug="{{ $inventory->slug }}">
                                                            <i class="nav-icon fas fa-trash"></i>
                                                        </button>
                                                    @endif
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

@section('script')
    <script>
        $(document).ready(function() {
            deleteAction('.delete-inventory', 'hostel/inventory');
            updatePublishStatus('.published', 'inventory/publish');
        });
    </script>
@endsection
