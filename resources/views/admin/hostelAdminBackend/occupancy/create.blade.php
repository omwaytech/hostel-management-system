@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Occupancy</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.occupancy.index') }}" class="text-primary">Index</a>
                </li>
                <li>{{ $occupancy ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <form
                            action="{{ $occupancy ? route('hostelAdmin.occupancy.update', $occupancy->slug) : route('hostelAdmin.occupancy.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($occupancy)
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="block_id">
                                        <h6>Hostel Block</h6>
                                    </label>
                                    <select name="block_id" id="block_id"
                                        class="form-control @error('block_id') is-invalid @enderror">
                                        <option value="" disabled
                                            {{ old('block_id', $occupancy->block_id ?? '') == '' ? 'selected' : '' }}>
                                            Please Choose One</option>

                                        @foreach ($blocks as $block)
                                            <option value="{{ $block->id }}"
                                                {{ old('block_id', $occupancy->block_id ?? '') == $block->id ? 'selected' : '' }}>
                                                {{ $block->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('block_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="occupancy_type">
                                        <h6>Occupancy Type</h6>
                                    </label>
                                    <input class="form-control @error('occupancy_type') is-invalid @enderror"
                                        id="occupancy_type" name="occupancy_type" type="text" placeholder="Eg: Single"
                                        value="{{ old('occupancy_type', $occupancy->occupancy_type ?? '') }}" />
                                    @error('occupancy_type')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="monthly_rent">
                                        <h6>Monthly Rent</h6>
                                    </label>
                                    <input class="form-control @error('monthly_rent') is-invalid @enderror"
                                        id="monthly_rent" name="monthly_rent" type="number" placeholder="Enter rent"
                                        value="{{ old('monthly_rent', $occupancy->monthly_rent ?? '') }}" />
                                    @error('monthly_rent')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-success float-right"><i class="far fa-hand-point-up"></i>
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
