@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{ $currentHostel->name }} Block</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.block.index') }}" class="text-primary">Index</a>
                </li>
                <li>{{ $block ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <form
                            action="{{ $block ? route('hostelAdmin.block.update', $block->slug) : route('hostelAdmin.block.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($block)
                                @method('PUT')
                            @endif
                            <input type="hidden" name="hostel_id" value="{{ $currentHostel->id }}">
                            <div class="row mb-4">
                                <div class="col-md-12 mb-4">
                                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="block-tab" data-toggle="tab" href="#block"
                                                role="tab" aria-controls="block" aria-selected="true">BLOCK</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="floor-tab" data-toggle="tab" href="#floor"
                                                role="tab" aria-controls="floor" aria-selected="false">FLOOR</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="occupancy-tab" data-toggle="tab" href="#occupancy"
                                                role="tab" aria-controls="occupancy" aria-selected="false">OCCUPANCY</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="image-tab" data-toggle="tab" href="#image"
                                                role="tab" aria-controls="image" aria-selected="false">IMAGE</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="meal-tab" data-toggle="tab" href="#meal"
                                                role="tab" aria-controls="meal" aria-selected="false">MEAL</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="block" role="tabpanel"
                                            aria-labelledby="block-tab">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="block_number">
                                                        <h6>Block Number <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('block_number') is-invalid @enderror"
                                                        id="block_number" name="block_number" type="number"
                                                        placeholder="Eg: 2"
                                                        value="{{ old('block_number', $block->block_number ?? '') }}" />
                                                    @error('block_number')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="name">
                                                        <h6>Block Name <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" type="text"
                                                        placeholder="Enter page name"
                                                        value="{{ old('name', $block->name ?? '') }}" />
                                                    @error('name')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="contact">
                                                        <h6>Contact <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('contact') is-invalid @enderror"
                                                        id="contact" name="contact" type="number"
                                                        placeholder="Enter contact"
                                                        value="{{ old('contact', $block->contact ?? '') }}" />
                                                    @error('contact')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="location">
                                                        <h6>Location <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('location') is-invalid @enderror"
                                                        id="location" name="location" type="text"
                                                        placeholder="Enter location"
                                                        value="{{ old('location', $block->location ?? '') }}" />
                                                    @error('location')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="email">
                                                        <h6>Email <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" type="email"
                                                        placeholder="Enter email"
                                                        value="{{ old('email', $block->email ?? '') }}" />
                                                    @error('email')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="no_of_floor">
                                                        <h6>Number of Floor <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('no_of_floor') is-invalid @enderror"
                                                        id="no_of_floor" name="no_of_floor" type="number"
                                                        placeholder="Enter number"
                                                        value="{{ old('no_of_floor', $block->no_of_floor ?? '') }}" />
                                                    @error('no_of_floor')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="warden_id">
                                                        <h6>Hostel Warden <code>*</code></h6>
                                                    </label>
                                                    <select name="warden_id" id="warden_id"
                                                        class="form-control @error('warden_id') is-invalid @enderror">
                                                        <option value="" disabled
                                                            {{ old('warden_id', $block->warden_id ?? '') == '' ? 'selected' : '' }}>
                                                            Please
                                                            Choose One</option>

                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ old('warden_id', $block->warden_id ?? '') == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('warden_id')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="map">
                                                        <h6>Google Map <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('map') is-invalid @enderror"
                                                        id="map" name="map" type="text"
                                                        placeholder="Enter link"
                                                        value="{{ old('map', $block->map ?? '') }}" />
                                                    @error('map')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>
                                                        <h6>Block Photo <code>*</code></h6>
                                                    </label><br>
                                                    <div class="d-flex justify-content-center">
                                                        @if ($block && $block->photo)
                                                            <img src="{{ asset('storage/images/blockPhotos/' . $block->photo) }}"
                                                                id="preview" alt="{{ $block->photo }}"
                                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                                        @else
                                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                                id="preview"
                                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                                        @endif
                                                        <input
                                                            class="ml-2 mt-2 form-control @error('photo') is-invalid @enderror"
                                                            type="file" name="photo" id="photo"
                                                            accept="image/jpeg,image/png,image/jpg"
                                                            value="{{ old('photo') }}"
                                                            onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                                    </div>
                                                    @error('photo')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                {{-- <div class="col-md-4 form-group mb-3">
                                                    <label for="facilities">
                                                        <h6>Room Facilities (Inclusion) <code> *</code></h6>
                                                    </label>
                                                    <div id="facilities-wrapper">
                                                        @php
                                                            $oldFacilities = old(
                                                                'facilities',
                                                                $block->facilities ?? [],
                                                            );
                                                            $facilitiesArray = is_string($oldFacilities)
                                                                ? json_decode($oldFacilities, true)
                                                                : $oldFacilities;
                                                        @endphp
                                                        @foreach ($facilitiesArray as $index => $val)
                                                            <div class="facilities-field mb-2">
                                                                <input
                                                                    class="form-control mb-2 @error('facilities.' . $index) is-invalid @enderror"
                                                                    name="facilities[]" type="text"
                                                                    value="{{ $val }}" />
                                                                @error('facilities.' . $index)
                                                                    <div class="text-danger">*{{ $message }}</div>
                                                                @enderror
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger remove-facilities mb-2"
                                                                    style="margin-top: 5px;">-</button>
                                                            </div>
                                                        @endforeach
                                                        @if (empty($facilitiesArray))
                                                            <div class="mb-2">
                                                                <input
                                                                    class="form-control mb-2 @error('facilities.0') is-invalid @enderror"
                                                                    name="facilities[]" placeholder="Enter here"
                                                                    type="text" />
                                                                @if ($errors->has('facilities.0'))
                                                                    <div class="text-danger">
                                                                        *{{ $errors->first('facilities.0') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @error('facilities')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        id="add-facilities">+
                                                        Add
                                                    </button>
                                                </div> --}}
                                                <div class="col-md-12 form-group">
                                                    <label for="description">
                                                        <h6>Description <code>*</code></h6>
                                                    </label>
                                                    <textarea class="form-control ckeditor @error('description') is-invalid @enderror" rows="6" id="description"
                                                        name="description" placeholder="Type Here..." />{{ old('description', $block->description ?? '') }}</textarea>
                                                    @error('description')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="floor" role="tabpanel"
                                            aria-labelledby="floor-tab">
                                            <div id="floorContainer">
                                                {{-- @dd($block->floors) --}}
                                                @if (isset($block->floors))
                                                    @if (old('floor'))
                                                        @foreach (old('floor') as $key => $floor)
                                                            <div class="separator-breadcrumb border-top">
                                                                <div class="floor-item">
                                                                    <div class="row">
                                                                        <input type="hidden"
                                                                            name="floor[{{ $key }}][id]"
                                                                            value="{{ $floor['id'] ?? '' }}" />

                                                                        <div class="col-md-5 form-group">
                                                                            <label for="floor_number">
                                                                                <h6>Floor Number <code>*</code></h6>
                                                                            </label>
                                                                            <input
                                                                                class="form-control @error('floor.' . $key . '.floor_number') is-invalid @enderror"
                                                                                id="floor_number"
                                                                                name="floor[{{ $key }}][floor_number]"
                                                                                type="number" placeholder="Eg: 1"
                                                                                value="{{ $floor['floor_number'] ?? '' }}" />
                                                                            @error('floor.' . $key . '.floor_number')
                                                                                <div class="text-danger">*{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-5 form-group">
                                                                            <label for="floor_label">
                                                                                <h6>Floor Label <code>*</code></h6>
                                                                            </label>
                                                                            <input
                                                                                class="form-control @error('floor.' . $key . '.floor_label') is-invalid @enderror"
                                                                                id="floor_label"
                                                                                name="floor[{{ $key }}][floor_label]"
                                                                                type="text"
                                                                                placeholder="Eg: Ground Floor"
                                                                                value="{{ $floor['floor_label'] ?? '' }}" />
                                                                            @error('floor.' . $key . '.floor_label')
                                                                                <div class="text-danger">*{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @elseif (isset($block->floors))
                                                        @foreach ($block->floors->where('is_deleted', false) as $floor)
                                                            <div class="floor-item">
                                                                <div class="row">
                                                                    <input type="hidden"
                                                                        name="floor[{{ $floor->id }}][id]"
                                                                        value="{{ $floor->id }}" />

                                                                    <div class="col-md-5 form-group">
                                                                        <label for="floor_number">
                                                                            <h6>Floor Number <code>*</code></h6>
                                                                        </label>
                                                                        <input
                                                                            class="form-control @error('floor.' . $floor->id . '.floor_number') is-invalid @enderror"
                                                                            id="floor_number"
                                                                            name="floor[{{ $floor->id }}][floor_number]"
                                                                            type="number" placeholder="Eg: 1"
                                                                            value="{{ $floor->floor_number }}" />
                                                                        @error('floor.' . $floor->id . '.floor_number')
                                                                            <div class="text-danger">*{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-5 form-group">
                                                                        <label for="floor_label">
                                                                            <h6>Floor Label <code>*</code></h6>
                                                                        </label>
                                                                        <input
                                                                            class="form-control @error('floor.' . $floor->id . '.floor_label') is-invalid @enderror"
                                                                            id="floor_label"
                                                                            name="floor[{{ $floor->id }}][floor_label]"
                                                                            type="text" placeholder="Eg: Ground Floor"
                                                                            value="{{ $floor->floor_label }}" />
                                                                        @error('floor.' . $floor->id . '.floor_label')
                                                                            <div class="text-danger">*{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div
                                                                        class="col-md-2 form-group d-flex align-items-center">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm mt-4 remove-floor">-</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @foreach (old('floor', []) as $key => $floor)
                                                        <div class="floor-item">
                                                            <div class="row">
                                                                <input type="hidden"
                                                                    name="floor[{{ $key }}][id]"
                                                                    value="{{ $key }}" />
                                                                <div class="col-md-5 form-group">
                                                                    <label for="floor_number">
                                                                        <h6>Floor Number <code>*</code></h6>
                                                                    </label>
                                                                    <input
                                                                        class="form-control @error('floor.' . $key . '.floor_number') is-invalid @enderror"
                                                                        id="floor_number"
                                                                        name="floor[{{ $key }}][floor_number]"
                                                                        type="number" placeholder="Eg: 1"
                                                                        value="{{ old('floor.' . $key . '.floor_number') }}" />
                                                                    @error('floor.' . $key . '.floor_number')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-5 form-group">
                                                                    <label for="floor_label">
                                                                        <h6>Floor Label <code>*</code></h6>
                                                                    </label>
                                                                    <input
                                                                        class="form-control @error('floor.' . $key . '.floor_label') is-invalid @enderror"
                                                                        id="floor_label"
                                                                        name="floor[{{ $key }}][floor_label]"
                                                                        type="text" placeholder="Eg: Ground Floor"
                                                                        value="{{ old('floor.' . $key . '.floor_label') }}" />
                                                                    @error('floor.' . $key . '.floor_label')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm ms-2 mb-2"
                                                id="add-floor">+
                                                New
                                            </button>
                                        </div>
                                        <div class="tab-pane fade" id="occupancy" role="tabpanel"
                                            aria-labelledby="occupancy-tab">
                                            <div id="occupancyContainer">
                                                {{-- @dd($block->occupancies) --}}
                                                @if (isset($block->occupancies))
                                                    @if (old('occupancy'))
                                                        @foreach (old('occupancy') as $key => $occupancy)
                                                            <div class="separator-breadcrumb border-top">
                                                                <div class="occupancy-item">
                                                                    <div class="row">
                                                                        <input type="hidden"
                                                                            name="occupancy[{{ $key }}][id]"
                                                                            value="{{ $occupancy['id'] ?? '' }}" />

                                                                        <div class="col-md-5 form-group">
                                                                            <label for="occupancy_type">
                                                                                <h6>Occupancy / Bed Type <code>*</code></h6>
                                                                            </label>
                                                                            <input
                                                                                class="form-control @error('occupancy.' . $key . '.occupancy_type') is-invalid @enderror"
                                                                                id="occupancy_type"
                                                                                name="occupancy[{{ $key }}][occupancy_type]"
                                                                                type="text" placeholder="Eg: Single"
                                                                                value="{{ $occupancy['occupancy_type'] ?? '' }}" />
                                                                            @error('occupancy.' . $key . '.occupancy_type')
                                                                                <div class="text-danger">*{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-5 form-group">
                                                                            <label for="monthly_rent">
                                                                                <h6>Monthly Rent <code>*</code></h6>
                                                                            </label>
                                                                            <input
                                                                                class="form-control @error('occupancy.' . $key . '.monthly_rent') is-invalid @enderror"
                                                                                id="monthly_rent"
                                                                                name="occupancy[{{ $key }}][monthly_rent]"
                                                                                type="text"
                                                                                placeholder="Eg: Enter Rent"
                                                                                value="{{ $occupancy['monthly_rent'] ?? '' }}" />
                                                                            @error('occupancy.' . $key . '.monthly_rent')
                                                                                <div class="text-danger">*{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @elseif (isset($block->occupancies))
                                                        @foreach ($block->occupancies->where('is_deleted', false) as $occupancy)
                                                            <div class="occupancy-item">
                                                                <div class="row">
                                                                    <input type="hidden"
                                                                        name="occupancy[{{ $occupancy->id }}][id]"
                                                                        value="{{ $occupancy->id }}" />
                                                                    <div class="col-md-5 form-group">
                                                                        <label for="occupancy_type">
                                                                            <h6>Occupancy / Bed Type <code>*</code></h6>
                                                                        </label>
                                                                        <input
                                                                            class="form-control @error('occupancy.' . $occupancy->id . '.occupancy_type') is-invalid @enderror"
                                                                            id="occupancy_type"
                                                                            name="occupancy[{{ $occupancy->id }}][occupancy_type]"
                                                                            type="text" placeholder="Eg: Single"
                                                                            value="{{ $occupancy->occupancy_type }}" />
                                                                        @error('occupancy.' . $occupancy->id .
                                                                            '.occupancy_type')
                                                                            <div class="text-danger">*{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-5 form-group">
                                                                        <label for="monthly_rent">
                                                                            <h6>Monthly Rent <code>*</code></h6>
                                                                        </label>
                                                                        <input
                                                                            class="form-control @error('occupancy.' . $occupancy->id . '.monthly_rent') is-invalid @enderror"
                                                                            id="monthly_rent"
                                                                            name="occupancy[{{ $occupancy->id }}][monthly_rent]"
                                                                            type="text" placeholder="Eg: Enter Rent"
                                                                            value="{{ $occupancy->monthly_rent }}" />
                                                                        @error('occupancy.' . $occupancy->id .
                                                                            '.monthly_rent')
                                                                            <div class="text-danger">*{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div
                                                                        class="col-md-2 form-group d-flex align-items-center">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm mt-4 remove-occupancy">-</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @foreach (old('occupancy', []) as $key => $occupancy)
                                                        <div class="occupancy-item">
                                                            <div class="row">
                                                                <input type="hidden"
                                                                    name="occupancy[{{ $key }}][id]"
                                                                    value="{{ $key }}" />
                                                                <div class="col-md-5 form-group">
                                                                    <label for="occupancy_type">
                                                                        <h6>Occupancy / Bed Type <code>*</code></h6>
                                                                    </label>
                                                                    <input
                                                                        class="form-control @error('occupancy.' . $key . '.occupancy_type') is-invalid @enderror"
                                                                        id="occupancy_type"
                                                                        name="occupancy[{{ $key }}][occupancy_type]"
                                                                        type="text" placeholder="Eg: Single"
                                                                        value="{{ old('occupancy.' . $key . '.occupancy_type') }}" />
                                                                    @error('occupancy.' . $key . '.occupancy_type')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-5 form-group">
                                                                    <label for="monthly_rent">
                                                                        <h6>Monthly Rent <code>*</code></h6>
                                                                    </label>
                                                                    <input
                                                                        class="form-control @error('occupancy.' . $key . '.monthly_rent') is-invalid @enderror"
                                                                        id="monthly_rent"
                                                                        name="occupancy[{{ $key }}][monthly_rent]"
                                                                        type="text" placeholder="Eg: Enter Rent"
                                                                        value="{{ old('occupancy.' . $key . '.monthly_rent') }}" />
                                                                    @error('occupancy.' . $key . '.monthly_rent')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm ms-2 mb-2"
                                                id="add-occupancy">+
                                                New
                                            </button>
                                        </div>
                                        <div class="tab-pane fade" id="image" role="tabpanel"
                                            aria-labelledby="image-tab">
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label for="image_uploads">
                                                        <h6>Upload Image (Can be multiple) <code>*</code></h6>
                                                    </label>
                                                    <input type="file" name="image_uploads[]" id="imageInput" multiple
                                                        accept="image/*" class="form-control mb-3" />
                                                    @error('image_uploads')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div id="image-gallery-wrapper">
                                                @if (isset($block->images))
                                                    <div id="image-list" class="row gy-3 gx-2"> {{-- Only one row --}}
                                                        @foreach ($block->images as $index => $image)
                                                            <div class="col-md-4 image-item"
                                                                data-index="{{ $index }}">
                                                                <div class="border rounded p-2 h-100">
                                                                    <img src="{{ asset('storage/images/blockImages/' . $image->image) }}"
                                                                        class="img-thumbnail mb-2 preview-image"
                                                                        style="max-width: 100px; max-height: 100px;"
                                                                        alt="Image">
                                                                    <input type="hidden"
                                                                        name="images_data[{{ $index }}][existing]"
                                                                        value="{{ $image->id }}">
                                                                    <input type="hidden"
                                                                        name="images_data[{{ $index }}][image]"
                                                                        value="{{ $image->image }}">

                                                                    <input type="text"
                                                                        name="images_data[{{ $index }}][caption]"
                                                                        value="{{ $image->caption }}"
                                                                        placeholder="Image caption"
                                                                        class="form-control mb-2" />

                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger remove-image">-</button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div id="image-list" class="row gy-3">
                                                        @if (old('images_data'))
                                                            @foreach (old('images_data') as $index => $data)
                                                                <div class="col-md-4 image-item"
                                                                    data-index="{{ $index }}">
                                                                    <div class="border rounded p-2 h-100">
                                                                        <input type="hidden"
                                                                            name="images_data[{{ $index }}][image]"
                                                                            value="{{ $data['image'] ?? '' }}">

                                                                        <input type="text"
                                                                            name="images_data[{{ $index }}][caption]"
                                                                            value="{{ $data['caption'] ?? '' }}"
                                                                            placeholder="Image caption"
                                                                            class="form-control mb-1 @error("images_data.$index.caption") is-invalid @enderror" />
                                                                        @error("images_data.$index.caption")
                                                                            <div class="text-danger small">{{ $message }}
                                                                            </div>
                                                                        @enderror

                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger remove-image mt-2">-</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="meal" role="tabpanel"
                                            aria-labelledby="meal-tab">
                                            <div class="container my-4">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered text-center align-middle">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Day</th>
                                                                <th>Early Morning</th>
                                                                <th>Morning</th>
                                                                <th>Day</th>
                                                                <th>Evening</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Sunday</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[sunday][early_morning]"
                                                                        value="{{ old('meals.sunday.early_morning', $meals['sunday']['early_morning'] ?? '') }}">
                                                                    @error('meals.sunday.early_morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[sunday][morning]"
                                                                        value="{{ old('meals.sunday.morning', $meals['sunday']['morning'] ?? '') }}">
                                                                    @error('meals.sunday.morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[sunday][day_meal]"
                                                                        value="{{ old('meals.sunday.day_meal', $meals['sunday']['day_meal'] ?? '') }}">
                                                                    @error('meals.sunday.day_meal')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[sunday][evening]"
                                                                        value="{{ old('meals.sunday.evening', $meals['sunday']['evening'] ?? '') }}">
                                                                    @error('meals.sunday.evening')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Monday</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[monday][early_morning]"
                                                                        value="{{ old('meals.monday.early_morning', $meals['monday']['early_morning'] ?? '') }}">
                                                                    @error('meals.monday.early_morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[monday][morning]"
                                                                        value="{{ old('meals.monday.morning', $meals['monday']['morning'] ?? '') }}">
                                                                    @error('meals.monday.morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[monday][day_meal]"
                                                                        value="{{ old('meals.monday.day_meal', $meals['monday']['day_meal'] ?? '') }}">
                                                                    @error('meals.monday.day_meal')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[monday][evening]"
                                                                        value="{{ old('meals.monday.evening', $meals['monday']['evening'] ?? '') }}">
                                                                    @error('meals.monday.evening')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tuesday</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[tuesday][early_morning]"
                                                                        value="{{ old('meals.tuesday.early_morning', $meals['tuesday']['early_morning'] ?? '') }}">
                                                                    @error('meals.tuesday.early_morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[tuesday][morning]"
                                                                        value="{{ old('meals.tuesday.morning', $meals['tuesday']['morning'] ?? '') }}">
                                                                    @error('meals.tuesday.morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[tuesday][day_meal]"
                                                                        value="{{ old('meals.tuesday.day_meal', $meals['tuesday']['day_meal'] ?? '') }}">
                                                                    @error('meals.tuesday.day_meal')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[tuesday][evening]"
                                                                        value="{{ old('meals.tuesday.evening', $meals['tuesday']['evening'] ?? '') }}">
                                                                    @error('meals.tuesday.evening')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Wednesday</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[wednesday][early_morning]"
                                                                        value="{{ old('meals.wednesday.early_morning', $meals['wednesday']['early_morning'] ?? '') }}">
                                                                    @error('meals.wednesday.early_morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[wednesday][morning]"
                                                                        value="{{ old('meals.wednesday.morning', $meals['wednesday']['morning'] ?? '') }}">
                                                                    @error('meals.wednesday.morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[wednesday][day_meal]"
                                                                        value="{{ old('meals.wednesday.day_meal', $meals['wednesday']['day_meal'] ?? '') }}">
                                                                    @error('meals.wednesday.day_meal')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[wednesday][evening]"
                                                                        value="{{ old('meals.wednesday.evening', $meals['wednesday']['evening'] ?? '') }}">
                                                                    @error('meals.wednesday.evening')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Thursday</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[thursday][early_morning]"
                                                                        value="{{ old('meals.thursday.early_morning', $meals['thursday']['early_morning'] ?? '') }}">
                                                                    @error('meals.thursday.early_morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[thursday][morning]"
                                                                        value="{{ old('meals.thursday.morning', $meals['thursday']['morning'] ?? '') }}">
                                                                    @error('meals.thursday.morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[thursday][day_meal]"
                                                                        value="{{ old('meals.thursday.day_meal', $meals['thursday']['day_meal'] ?? '') }}">
                                                                    @error('meals.thursday.day_meal')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[thursday][evening]"
                                                                        value="{{ old('meals.thursday.evening', $meals['thursday']['evening'] ?? '') }}">
                                                                    @error('meals.thursday.evening')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Friday</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[friday][early_morning]"
                                                                        value="{{ old('meals.friday.early_morning', $meals['friday']['early_morning'] ?? '') }}">
                                                                    @error('meals.friday.early_morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[friday][morning]"
                                                                        value="{{ old('meals.friday.morning', $meals['friday']['morning'] ?? '') }}">
                                                                    @error('meals.friday.morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[friday][day_meal]"
                                                                        value="{{ old('meals.friday.day_meal', $meals['friday']['day_meal'] ?? '') }}">
                                                                    @error('meals.friday.day_meal')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[friday][evening]"
                                                                        value="{{ old('meals.friday.evening', $meals['friday']['evening'] ?? '') }}">
                                                                    @error('meals.friday.evening')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Saturday</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[saturday][early_morning]"
                                                                        value="{{ old('meals.saturday.early_morning', $meals['saturday']['early_morning'] ?? '') }}">
                                                                    @error('meals.saturday.early_morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[saturday][morning]"
                                                                        value="{{ old('meals.saturday.morning', $meals['saturday']['morning'] ?? '') }}">
                                                                    @error('meals.saturday.morning')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[saturday][day_meal]"
                                                                        value="{{ old('meals.saturday.day_meal', $meals['saturday']['day_meal'] ?? '') }}">
                                                                    @error('meals.saturday.day_meal')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="meals[saturday][evening]"
                                                                        value="{{ old('meals.saturday.evening', $meals['saturday']['evening'] ?? '') }}">
                                                                    @error('meals.saturday.evening')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <h5 class="text-center"><strong>BLOCK</strong></h5>
                            <div class="separator-breadcrumb border-top"></div>

                            <h5 class="text-center mt-2"><strong>FLOORS</strong></h5>
                            <div class="separator-breadcrumb border-top"></div>

                            <h5 class="text-center mt-2"><strong>OCCUPANCY</strong></h5>
                            <div class="separator-breadcrumb border-top"></div>

                            <h5 class="text-center mt-2"><strong>BLOCK IMAGES</strong></h5>
                            <div class="separator-breadcrumb border-top"></div> --}}

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

@section('script')
    <script>
        $(document).ready(function() {
            $('#add-facilities').click(function() {
                $('#facilities-wrapper').append(
                    '<div class="facilities-field mb-2">' +
                    '<input class="form-control mb-2" name="facilities[]" placeholder="Enter here" type="text" />' +
                    '<button type="button" class="btn btn-sm btn-danger remove-facilities" style="margin-top: 5px;">-</button>' +
                    '</div>'
                );
            });
            $('#facilities-wrapper').on('click', '.remove-facilities', function() {
                $(this).closest('.facilities-field').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let newFloorCount = 0;

            function addFloorItem() {
                const newIndex = `new_${newFloorCount++}`;
                let floorItem = `
                    <div class="floor-item" data-index="${newIndex}">
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <label><h6>Floor Number <code>*</code></h6></label>
                                <input class="form-control" name="floor[${newIndex}][floor_number]" type="text" placeholder="Eg: 1" />
                            </div>
                            <div class="col-md-5 form-group">
                                <label><h6>Floor Label <code>*</code></h6></label>
                                <input class="form-control" name="floor[${newIndex}][floor_label]" type="text" placeholder="Eg: Ground Floor" />
                            </div>
                            <div class="col-md-2 form-group d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm mt-4 remove-floor">-</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#floorContainer').append(floorItem);
            }

            if ($(".floor-item").length === 0) {
                addFloorItem();
            }

            $('#add-floor').on('click', function() {
                addFloorItem();
            });

            $(document).on('click', '.remove-floor', function() {
                $(this).closest('.floor-item').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let newOccupancyCount = 0;

            function addOccupancyItem() {
                const newIndex = `new_${newOccupancyCount++}`;
                let OccupancyItem = `
                    <div class="occupancy-item" data-index="${newIndex}">
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <label><h6>Occupancy / Bed Type <code>*</code></h6></label>
                                <input class="form-control" name="occupancy[${newIndex}][occupancy_type]" type="text" placeholder="Eg: Single" />
                            </div>
                            <div class="col-md-5 form-group">
                                <label><h6>Monthly Rent <code>*</code></h6></label>
                                <input class="form-control" name="occupancy[${newIndex}][monthly_rent]" type="text" placeholder="Enter Rent" />
                            </div>
                            <div class="col-md-2 form-group d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm mt-4 remove-occupancy">-</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#occupancyContainer').append(OccupancyItem);
            }

            if ($(".occupancy-item").length === 0) {
                addOccupancyItem();
            }

            $('#add-occupancy').on('click', function() {
                addOccupancyItem();
            });

            $(document).on('click', '.remove-occupancy', function() {
                $(this).closest('.occupancy-item').remove();
            });
        });
    </script>
    <script>
        let imageIndex = {{ isset($block) && $block->images ? count($block->images) : 0 }};

        $('#imageInput').on('change', function(e) {
            const files = e.target.files;

            $.each(files, function(i, file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    const preview = `
                    <div class="col-md-4 image-item" data-index="${imageIndex}">
                        <div class="border rounded p-2 h-100">
                            <img src="${event.target.result}" class="img-thumbnail mb-2" style="max-width: 100px; max-height: 100px;" alt="Preview">
                            <input type="hidden" name="images_data[${imageIndex}][image]" value="${file.name}">
                            <input type="text" name="images_data[${imageIndex}][caption]" placeholder="Image caption" class="form-control mb-2" />
                            <button type="button" class="btn btn-sm btn-danger remove-image">-</button>
                        </div>
                    </div>
                `;
                    $('#image-list').append(preview);
                    imageIndex++;
                };

                reader.readAsDataURL(file);
            });
        });

        $('#image-list').on('click', '.remove-image', function() {
            $(this).closest('.image-item').remove();
        });
    </script>
@endsection
