@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{ $currentHostel->name }} Room</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.room.index') }}" class="text-primary">Index</a>
                </li>
                <li>{{ $room ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 bg-white">
                    <div class="card-body">
                        <form
                            action="{{ $room ? route('hostelAdmin.room.update', $room->slug) : route('hostelAdmin.room.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($room)
                                @method('PUT')
                            @endif
                            <div class="row mb-4">
                                <div class="col-md-12 mb-4">
                                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="room-tab" data-toggle="tab" href="#room"
                                                role="tab" aria-controls="room" aria-selected="true">ROOM</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="bed-tab" data-toggle="tab" href="#bed"
                                                role="tab" aria-controls="bed" aria-selected="false">BED</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="room" role="tabpanel"
                                            aria-labelledby="room-tab">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="block_id">
                                                        <h6>Hostel Block <code>*</code></h6>
                                                    </label>
                                                    <select name="block_id" id="block_id"
                                                        class="form-control @error('block_id') is-invalid @enderror">
                                                        <option value="" disabled
                                                            {{ old('block_id', $block_id ?? '') == '' ? 'selected' : '' }}>
                                                            Please Choose One
                                                        </option>
                                                        @foreach ($blocks as $block)
                                                            <option value="{{ $block->id }}"
                                                                {{ old('block_id', $block_id ?? '') == $block->id ? 'selected' : '' }}>
                                                                {{ $block->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('block_id')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label for="floor_id">
                                                        <h6>Hostel Floor <code>*</code></h6>
                                                    </label>
                                                    <select name="floor_id" id="floor_id"
                                                        class="form-control @error('floor_id') is-invalid @enderror">
                                                        <option value="" disabled selected>Please Choose Block First
                                                        </option>
                                                        @if (old('floor_id') || (isset($room) && $room->floor_id))
                                                            <option value="{{ old('floor_id', $room->floor_id ?? '') }}"
                                                                selected hidden>
                                                                {{ old('floor_label', $room->floor?->floor_label ?? 'Select Floor') }}
                                                            </option>
                                                        @endif
                                                    </select>
                                                    @error('floor_id')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label for="occupancy_id">
                                                        <h6>Room Occupancy <code>*</code></h6>
                                                    </label>
                                                    <select name="occupancy_id" id="occupancy_id"
                                                        class="form-control @error('occupancy_id') is-invalid @enderror">
                                                        <option value="" disabled selected>Please Choose Block First
                                                        </option>
                                                        @if (old('occupancy_id') || (isset($room) && $room->occupancy_id))
                                                            <option
                                                                value="{{ old('occupancy_id', $room->occupancy_id ?? '') }}"
                                                                selected hidden>
                                                                {{ old('occupancy_type', $room->occupancy?->occupancy_type ?? 'Select Occupancy') }}
                                                            </option>
                                                        @endif
                                                    </select>
                                                    @error('occupancy_id')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label for="room_number">
                                                        <h6>Room Number <code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('room_number') is-invalid @enderror"
                                                        id="room_number" name="room_number" type="number"
                                                        placeholder="Eg: 2"
                                                        value="{{ old('room_number', $room->room_number ?? '') }}" />
                                                    @error('room_number')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label>
                                                        Room Photo <code>*</code></h6>
                                                    </label><br>
                                                    <div class="d-flex justify-content-center">
                                                        @if ($room && $room->photo)
                                                            <img src="{{ asset('storage/images/roomPhotos/' . $room->photo) }}"
                                                                id="preview" alt="{{ $room->photo }}"
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
                                                {{-- <div class="col-md-3 form-group">
                                                    <label for="room_type">
                                                        <h6>Room Type <code>*</code></h6>
                                                    </label>
                                                    <select class="form-control @error('room_type') is-invalid @enderror" id="room_type"
                                                        name="room_type">
                                                        <option value="" disabled selected>Please Choose One</option>
                                                        <option
                                                            value="Single"{{ old('room_type', $room->room_type ?? '') == 'Single' ? 'selected' : '' }}>
                                                            Single - 1
                                                        </option>
                                                        <option
                                                            value="Double"{{ old('room_type', $room->room_type ?? '') == 'Double' ? 'selected' : '' }}>
                                                            Double - 2
                                                        </option>
                                                        <option
                                                            value="Triple"{{ old('room_type', $room->room_type ?? '') == 'Triple' ? 'selected' : '' }}>
                                                            Triple - 3
                                                        </option>
                                                        <option
                                                            value="Quadruple"{{ old('room_type', $room->room_type ?? '') == 'Quadruple' ? 'selected' : '' }}>
                                                            Quadruple - 4
                                                        </option>
                                                        <option
                                                            value="Quintuple"{{ old('room_type', $room->room_type ?? '') == 'Quintuple' ? 'selected' : '' }}>
                                                            Quintuple - 5
                                                        </option>
                                                    </select>
                                                    @error('room_type')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div> --}}
                                                <div class="col-md-3 form-group">
                                                    <label for="has_attached_bathroom">
                                                        <h6>Attached Bathroom <code>*</code></h6>
                                                    </label>
                                                    <select
                                                        class="form-control @error('has_attached_bathroom') is-invalid @enderror"
                                                        id="has_attached_bathroom" name="has_attached_bathroom">
                                                        <option value="" disabled selected>Please Choose One</option>
                                                        <option value="0"
                                                            {{ old('has_attached_bathroom', $room->has_attached_bathroom ?? '') == 0 ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="1"
                                                            {{ old('has_attached_bathroom', $room->has_attached_bathroom ?? '') == 1 ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                    @error('has_attached_bathroom')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label for="room_size">
                                                        <h6>Room Size (sq ft)<code>*</code></h6>
                                                    </label>
                                                    <input class="form-control @error('room_size') is-invalid @enderror"
                                                        id="room_size" name="room_size" type="text"
                                                        placeholder="Eg: 123"
                                                        value="{{ old('room_size', $room->room_size ?? '') }}" />
                                                    @error('room_size')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label for="room_window_number">
                                                        <h6>Room Window Number <code>*</code></h6>
                                                    </label>
                                                    <input
                                                        class="form-control @error('room_window_number') is-invalid @enderror"
                                                        id="room_window_number" name="room_window_number" type="number"
                                                        placeholder="Eg: 2"
                                                        value="{{ old('room_window_number', $room->room_window_number ?? '') }}" />
                                                    @error('room_window_number')
                                                        <div class="text-danger">*{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3 mt-3">
                                                    <label for="room_inclusions">
                                                        <h6>Room Inclusions <code> *</code></h6>
                                                    </label>
                                                    <div id="inclusion-wrapper">
                                                        @php
                                                            $oldInclusion = old(
                                                                'room_inclusions',
                                                                $room->room_inclusions ?? [],
                                                            );
                                                            $inclusionArray = is_string($oldInclusion)
                                                                ? json_decode($oldInclusion, true)
                                                                : $oldInclusion;
                                                        @endphp
                                                        @foreach ($inclusionArray as $index => $val)
                                                            <div class="inclusion-field mb-2">
                                                                <input
                                                                    class="form-control mb-2 @error('room_inclusions.' . $index) is-invalid @enderror"
                                                                    name="room_inclusions[]" type="text"
                                                                    value="{{ $val }}" />
                                                                @error('room_inclusions.' . $index)
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger remove-inclusion mb-2"
                                                                    style="margin-top: 5px;">-</button>
                                                            </div>
                                                        @endforeach
                                                        @if (empty($inclusionArray))
                                                            <div class="metaTags-field mb-2">
                                                                <input
                                                                    class="form-control mb-2 @error('room_inclusions.0') is-invalid @enderror"
                                                                    name="room_inclusions[]" placeholder="Enter inclusion"
                                                                    type="text" />
                                                                @if ($errors->has('room_inclusions.0'))
                                                                    <div class="text-danger">
                                                                        {{ $errors->first('room_inclusions.0') }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @error('room_inclusions')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        id="add-inclusion">+
                                                        Add
                                                    </button>
                                                </div>

                                                <div id="amenityContainer" class="col-md-6 form-group mb-3">
                                                    @if (isset($room->roomAmenities))
                                                        {{-- If validation fails, show old() values --}}
                                                        @if (old('amenity'))
                                                            @foreach (old('amenity') as $key => $amenity)
                                                                <div class="amenity-item mb-3 rounded mt-3">
                                                                    <input type="hidden"
                                                                        name="amenity[{{ $key }}][id]"
                                                                        value="{{ $amenity['id'] ?? '' }}">
                                                                    <label>
                                                                        <h6>Amenity Name <code>*</code></h6>
                                                                    </label>
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <input type="text"
                                                                            name="amenity[{{ $key }}][amenity_name]"
                                                                            class="form-control w-50 ms-2 @error('amenity.' . $key . '.amenity_name') is-invalid @enderror"
                                                                            placeholder="Enter amenity name"
                                                                            value="{{ $amenity['amenity_name'] ?? '' }}">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm ms-2 ml-2 removeAmenity">x</button>
                                                                    </div>

                                                                    @error('amenity.' . $key . '.amenity_name')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror

                                                                    <div class="row mt-1 mb-3">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">Amenity Icon
                                                                                <code>*</code></label>
                                                                            <div class="d-flex align-items-center">
                                                                                <select
                                                                                    name="amenity[{{ $key }}][amenity_icon]"
                                                                                    class="form-control icon-dropdown"
                                                                                    onchange="previewAmenityIcon(this)">
                                                                                    <option value="">-- Select Icon
                                                                                        --</option>
                                                                                    @foreach ($icons as $icon)
                                                                                        <option
                                                                                            value="{{ $icon->icon_path }}"
                                                                                            data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}"
                                                                                            {{ old('amenity.' . $key . '.amenity_icon', $amenity['amenity_icon'] ?? '') == $icon->icon_path ? 'selected' : '' }}>
                                                                                            {{ $icon->icon_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <img src="{{ isset($amenity['amenity_icon']) ? asset($amenity['amenity_icon']) : asset('assets/images/noPreview.jpeg') }}"
                                                                                    class="img-preview ms-2 ml-2"
                                                                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                                                                            </div>
                                                                            @error('amenity.' . $key . '.amenity_icon')
                                                                                <div class="text-danger">*{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            {{-- If editing existing room amenities --}}
                                                        @elseif (isset($room->roomAmenities))
                                                            @foreach ($room->roomAmenities->where('is_deleted', 0) as $index => $amenity)
                                                                <div class="amenity-item mb-3 rounded mt-3">
                                                                    <input type="hidden"
                                                                        name="amenity[{{ $index }}][id]"
                                                                        value="{{ $amenity->id }}">
                                                                    <label>
                                                                        <h6>Amenity Name <code>*</code></h6>
                                                                    </label>
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <input type="text"
                                                                            name="amenity[{{ $index }}][amenity_name]"
                                                                            class="form-control w-50 ms-2 @error('amenity.' . $index . '.amenity_name') is-invalid @enderror"
                                                                            placeholder="Enter amenity name"
                                                                            value="{{ $amenity->amenity_name }}">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm ms-2 ml-2 removeAmenity">-</button>
                                                                    </div>

                                                                    @error('amenity.' . $index . '.amenity_name')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror

                                                                    <div class="row mt-1 mb-3">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">
                                                                                Amenity Icon
                                                                                <code>*</code></label>
                                                                            <div class="d-flex align-items-center">
                                                                                <select
                                                                                    name="amenity[{{ $index }}][amenity_icon]"
                                                                                    class="form-control icon-dropdown"
                                                                                    onchange="previewAmenityIcon(this)">
                                                                                    <option value="">-- Select Icon
                                                                                        --</option>
                                                                                    @foreach ($icons as $icon)
                                                                                        <option
                                                                                            value="{{ $icon->icon_path }}"
                                                                                            data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}"
                                                                                            {{ $amenity->amenity_icon == $icon->icon_path ? 'selected' : '' }}>
                                                                                            {{ $icon->icon_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <img src="{{ $amenity->amenity_icon ? asset('storage/images/icons/' . $amenity->amenity_icon) : asset('assets/images/noPreview.jpeg') }}"
                                                                                    class="img-preview ms-2 ml-2"
                                                                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            <button type="button" class="btn btn-primary btn-sm ms-2"
                                                                id="addAmenity">+ New</button>
                                                        @endif
                                                    @else
                                                        {{-- Default (when creating new) --}}
                                                        @foreach (old('amenity', ['']) as $key => $amenity)
                                                            <div class="amenity-item mb-3 rounded mt-3">
                                                                <label>
                                                                    <h6>Amenity Name <code>*</code></h6>
                                                                </label>
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <input type="text"
                                                                        name="amenity[{{ $key }}][amenity_name]"
                                                                        class="form-control w-50 ms-2 @error('amenity.' . $key . '.amenity_name') is-invalid @enderror"
                                                                        placeholder="Enter amenity name"
                                                                        value="{{ old('amenity.' . $key . '.amenity_name') }}">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm ms-2 ml-2 removeAmenity">-</button>
                                                                </div>

                                                                @error('amenity.' . $key . '.amenity_name')
                                                                    <div class="text-danger">*{{ $message }}</div>
                                                                @enderror

                                                                <div class="row mt-1 mb-3">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Amenity Icon
                                                                            <code>*</code></label>
                                                                        <div class="d-flex align-items-center">
                                                                            <select
                                                                                name="amenity[{{ $key }}][amenity_icon]"
                                                                                class="form-control icon-dropdown"
                                                                                onchange="previewAmenityIcon(this)">
                                                                                <option value="">-- Select Icon --
                                                                                </option>
                                                                                @foreach ($icons as $icon)
                                                                                    <option value="{{ $icon->icon_path }}"
                                                                                        data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}">
                                                                                        {{ $icon->icon_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                                                class="img-preview ms-2 ml-2"
                                                                                style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                                                                        </div>
                                                                        @error('amenity.' . $key . '.amenity_icon')
                                                                            <div class="text-danger">*{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <button type="button" class="btn btn-primary btn-sm ms-2"
                                                            id="addAmenity">+ New</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="bed" role="tabpanel"
                                            aria-labelledby="bed-tab">
                                            <h5>
                                                <p class="text-center">
                                                    Beds in Room Number
                                                    <span id="displayRoomNumber"></span>
                                                </p>
                                            </h5>
                                            <div id="bedContainer">
                                                @if (isset($room->beds))
                                                    @if (old('bed'))
                                                        @foreach (old('bed') as $key => $bed)
                                                            <div class="separator-breadcrumb border-top">
                                                                <div class="bed-item">
                                                                    <div class="row">
                                                                        <input type="hidden"
                                                                            name="bed[{{ $key }}][id]"
                                                                            value="{{ $bed['id'] ?? '' }}" />

                                                                        <div class="col-md-3 form-group">
                                                                            <label for="bed_number">
                                                                                <h6>Bed Number <code>*</code></h6>
                                                                            </label>
                                                                            <input
                                                                                class="form-control @error('bed.' . $key . '.bed_number') is-invalid @enderror"
                                                                                id="bed_number"
                                                                                name="bed[{{ $key }}][bed_number]"
                                                                                type="number" placeholder="Eg: 1"
                                                                                value="{{ $bed['bed_number'] ?? '' }}" />
                                                                            @error('bed.' . $key . '.bed_number')
                                                                                <div class="text-danger">*{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label>
                                                                                <h6>Bed Photo <code>*</code></h6>
                                                                            </label>
                                                                            <div
                                                                                class="d-flex justify-content-center align-items-center">
                                                                                <input type="file"
                                                                                    name="bed[{{ $key }}][photo]"
                                                                                    class="form-control @error('bed[{{ $key }}][photo]') is-invalid @enderror mr-3"
                                                                                    onchange="previewImage(this, 'static')">
                                                                                <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                                                    id="preview-static"
                                                                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                                    alt="Preview Image" />
                                                                            </div>
                                                                            @error('bed.' . $key . '.photo')
                                                                                <div class="text-danger">
                                                                                    *{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-3 form-group">
                                                                            <label for="status">
                                                                                <h6>Status <code>*</code></h6>
                                                                            </label>
                                                                            <select
                                                                                class="form-control @error('bed.' . $key . '.status') is-invalid @enderror"
                                                                                name="bed[{{ $key }}][status]"
                                                                                id="status">
                                                                                <option value="" disabled selected>
                                                                                    Please Choose One
                                                                                </option>
                                                                                <option
                                                                                    value="Available"{{ $bed['status'] ?? '' == 'Available' ? 'selected' : '' }}>
                                                                                    Available
                                                                                </option>
                                                                                <option
                                                                                    value="Occupied"{{ $bed['status'] ?? '' == 'Occupied' ? 'selected' : '' }}>
                                                                                    Occupied
                                                                                </option>
                                                                                <option
                                                                                    value="OnMaintenance"{{ $bed['status'] ?? '' == 'OnMaintenance' ? 'selected' : '' }}>
                                                                                    On Maintenance
                                                                                </option>
                                                                            </select>
                                                                            @error('bed.' . $key . '.status')
                                                                                <div class="text-danger">*{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @elseif (isset($room->beds))
                                                        @foreach ($room->beds->where('is_deleted', false) as $bed)
                                                            <div class="bed-item">
                                                                <div class="row">
                                                                    <input type="hidden"
                                                                        name="bed[{{ $bed->id }}][id]"
                                                                        value="{{ $bed->id }}" />

                                                                    <div class="col-md-3 form-group">
                                                                        <label for="bed_number">
                                                                            <h6>Bed Number <code>*</code></h6>
                                                                        </label>
                                                                        <input
                                                                            class="form-control @error('bed.' . $bed->id . '.bed_number') is-invalid @enderror"
                                                                            id="bed_number"
                                                                            name="bed[{{ $bed->id }}][bed_number]"
                                                                            type="number" placeholder="Eg: 1"
                                                                            value="{{ $bed->bed_number }}" />
                                                                        @error('bed.' . $bed->id . '.bed_number')
                                                                            <div class="text-danger">*{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <input type="hidden"
                                                                        name="bed[{{ $bed->id }}][photo]"
                                                                        value="{{ $bed->photo }}">
                                                                    <div class="col-md-4">
                                                                        <label>
                                                                            <h6>Bed Photo <code>*</code></h6>
                                                                        </label>
                                                                        <div
                                                                            class="d-flex justify-content-center align-items-center">
                                                                            <input type="file"
                                                                                name="bed[{{ $bed->id }}][photo]"
                                                                                class="form-control @error('bed.' . $bed->id . '.photo') is-invalid @enderror mr-3"
                                                                                onchange="previewStoredImage(this, {{ $bed->id }})">
                                                                            <img src="{{ $bed->photo ? asset('storage/images/bedPhotos/' . $bed->photo) : asset('assets/images/noPreview.jpeg') }}"
                                                                                id="imagePreview-{{ $bed->id }}"
                                                                                style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                                alt="Preview Image" />
                                                                        </div>
                                                                        @error('bed.' . $bed->id . '.photo')
                                                                            <div class="text-danger">
                                                                                *{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-3 form-group">
                                                                        <label for="status">
                                                                            <h6>Status <code>*</code></h6>
                                                                        </label>
                                                                        @php
                                                                            $selectedStatus = old(
                                                                                "bed.$bed->id.status",
                                                                                $bed->status,
                                                                            );
                                                                        @endphp
                                                                        <select
                                                                            class="form-control @error('bed.' . $bed->id . '.status') is-invalid @enderror"
                                                                            name="bed[{{ $bed->id }}][status]"
                                                                            id="status">
                                                                            <option value="" disabled
                                                                                {{ $selectedStatus ? '' : 'selected' }}>
                                                                                Please Choose One</option>
                                                                            @foreach (['Available', 'Occupied', 'OnMaintenance'] as $status)
                                                                                <option value="{{ $status }}"
                                                                                    {{ $selectedStatus == $status ? 'selected' : '' }}>
                                                                                    {{ $status }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('bed.' . $bed->id . '.status')
                                                                            <div class="text-danger">*{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div
                                                                        class="col-md-2 form-group d-flex align-items-center">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm mt-4 remove-bed">-</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @foreach (old('bed', []) as $key => $bed)
                                                        <div class="bed-item">
                                                            <div class="row">
                                                                <input type="hidden" name="bed[{{ $key }}][id]"
                                                                    value="{{ $key }}" />
                                                                <div class="col-md-3 form-group">
                                                                    <label for="bed_number">
                                                                        <h6>Bed Number <code>*</code></h6>
                                                                    </label>
                                                                    <input
                                                                        class="form-control @error('bed.' . $key . '.bed_number') is-invalid @enderror"
                                                                        id="bed_number"
                                                                        name="bed[{{ $key }}][bed_number]"
                                                                        type="number" placeholder="Eg: 1"
                                                                        value="{{ old('bed.' . $key . '.bed_number') }}" />
                                                                    @error('bed.' . $key . '.bed_number')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>
                                                                        <h6>Bed Photo <code>*</code></h6>
                                                                    </label>
                                                                    <div
                                                                        class="d-flex justify-content-center align-items-center">
                                                                        <input type="file"
                                                                            name="bed[{{ $key }}][photo]"
                                                                            class="form-control @error('bed[{{ $key }}][photo]') is-invalid @enderror mr-3"
                                                                            onchange="previewImage(this, 'static')">
                                                                        <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                                                            id="preview-static"
                                                                            style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                                            alt="Preview Image" />
                                                                    </div>
                                                                    @error('bed.' . $key . '.photo')
                                                                        <div class="text-danger">
                                                                            *{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-md-3 form-group">
                                                                    <label for="status">
                                                                        <h6>Status <code>*</code></h6>
                                                                    </label>
                                                                    <select
                                                                        class="form-control @error('bed.' . $key . '.status') is-invalid @enderror"
                                                                        name="bed[{{ $key }}][status]"
                                                                        id="status">
                                                                        <option value="" disabled selected>Please
                                                                            Choose One</option>
                                                                        <option
                                                                            value="Available"{{ old("bed.$key.status") == 'Available' ? 'selected' : '' }}>
                                                                            Available
                                                                        </option>
                                                                        <option
                                                                            value="Occupied"{{ old("bed.$key.status") == 'Occupied' ? 'selected' : '' }}>
                                                                            Occupied
                                                                        </option>
                                                                        <option
                                                                            value="OnMaintenance"{{ old("bed.$key.status") == 'OnMaintenance' ? 'selected' : '' }}>
                                                                            On Maintenance
                                                                        </option>
                                                                    </select>
                                                                    @error('bed.' . $key . '.status')
                                                                        <div class="text-danger">*{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm ms-2 mb-2"
                                                id="add-bed">+
                                                New
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <h5 class="text-center"><strong>ROOM</strong></h5>
                            <div class="separator-breadcrumb border-top"></div>

                            <h5 class="text-center mt-2"><strong>BEDS</strong></h5>
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
            $('#add-inclusion').click(function() {
                $('#inclusion-wrapper').append(
                    '<div class="inclusion-field mb-2">' +
                    '<input class="form-control mb-2" name="room_inclusions[]" placeholder="Enter inclusion" type="text" />' +
                    '<button type="button" class="btn btn-sm btn-danger remove-inclusion" style="margin-top: 5px;">-</button>' +
                    '</div>'
                );
            });
            $('#inclusion-wrapper').on('click', '.remove-inclusion', function() {
                $(this).closest('.inclusion-field').remove();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let amenityIndex =
                {{ isset($room->roomAmenities) ? $room->roomAmenities->count() : count(old('amenity', [''])) }};

            // Add new amenity field
            $('#addAmenity').on('click', function() {
                let newAmenity = `
                <div class="amenity-item mb-3 rounded mt-3">
                    <label>
                        <h6>Amenity Name <code>*</code></h6>
                    </label>
                    <div class="d-flex align-items-center mb-2">
                        <input type="text" name="amenity[${amenityIndex}][amenity_name]"
                            class="form-control w-50 ms-2" placeholder="Enter amenity name" required>
                        <button type="button" class="btn btn-danger btn-sm ms-2 ml-2 removeAmenity">-</button>
                    </div>
                    <div class="row mt-1 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Amenity Icon <code>*</code></label>
                            <div class="d-flex align-items-center">
                                <select name="amenity[${amenityIndex}][amenity_icon]" class="form-control icon-dropdown" onchange="previewAmenityIcon(this)" required>
                                    <option value="">-- Select Icon --</option>
                                    @foreach ($icons as $icon)
                                        <option value="{{ $icon->icon_path }}" data-icon="{{ asset('storage/images/icons/' . $icon->icon_path) }}">{{ $icon->icon_name }}</option>
                                    @endforeach
                                </select>
                                <img src="{{ asset('assets/images/noPreview.jpeg') }}" class="img-preview ms-2 ml-2"
                                    style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" />
                            </div>
                        </div>
                    </div>
                </div>
            `;
                $('#addAmenity').before(newAmenity);
                amenityIndex++;
            });

            // Remove amenity field
            $(document).on('click', '.removeAmenity', function() {
                $(this).closest('.amenity-item').remove();
            });
        });

        // Preview selected icon
        function previewAmenityIcon(select) {
            const selectedOption = $(select).find(':selected');
            const iconUrl = selectedOption.data('icon');
            $(select).closest('.d-flex').find('.img-preview').attr('src', iconUrl ||
                "{{ asset('assets/images/noPreview.jpeg') }}");
        }
    </script>

    <script>
        $(document).ready(function() {
            let newBedCount = 0;

            function addBedItem() {
                const newIndex = `new_${newBedCount++}`;
                let bedItem = `
                    <div class="bed-item" data-index="${newIndex}">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label><h6>Bed Number <code>*</code></h6></label>
                                <input class="form-control" name="bed[${newIndex}][bed_number]" type="text" placeholder="Eg: 1" />
                            </div>
                            <div class="col-md-4">
                                <label><h6>Bed Photo <code>*</code></h6></label>
                                <div class="d-flex align-items-center">
                                    <input type="file"
                                        name="bed[${newIndex}][photo]"
                                        class="form-control mr-3"
                                        onchange="previewImage(this, '${newIndex}')">
                                    <img src="{{ asset('assets/images/noPreview.jpeg') }}"
                                        id="preview-${newIndex}"
                                        style="max-width: 50px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                        alt="Default Image" />
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label><h6>Status <code>*</code></h6></label>
                                <select class="form-control" name="bed[${newIndex}][status]" id="status">
                                    <option value="" disabled selected>Please Choose One</option>
                                    <option value="Available">Available</option>
                                    <option value="Occupied">Occupied</option>
                                    <option value="OnMaintenance">OnMaintenance</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm mt-4 remove-bed">-</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#bedContainer').append(bedItem);
            }


            if ($(".bed-item").length === 0) {
                addBedItem();
            }

            $('#add-bed').on('click', function() {
                addBedItem();
            });

            $(document).on('click', '.remove-bed', function() {
                $(this).closest('.bed-item').remove();
            });
        });

        function previewImage(input, newIndex) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(`preview-${newIndex}`).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function previewStoredImage(input, bedId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(`imagePreview-${bedId}`).src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#block_id').on('change', function() {
                var blockId = $(this).val();
                var $floorSelect = $('#floor_id');
                var $occupancySelect = $('#occupancy_id');
                var oldFloorId = "{{ old('floor_id', $room->floor_id ?? '') }}";
                var oldOccupancyId = "{{ old('occupancy_id', $room->occupancy_id ?? '') }}";

                // Fetch floors
                $.ajax({
                    url: `${blockId}/floors`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $floorSelect.empty();

                        if (data.length > 0) {
                            $floorSelect.append(
                                '<option value="" disabled>Please Choose One</option>');

                            $.each(data, function(index, floor) {
                                var selected = (floor.id == oldFloorId) ? 'selected' : '';
                                $floorSelect.append(
                                    `<option value="${floor.id}" ${selected}>${floor.floor_label}</option>`
                                );
                            });

                            // If no floor is selected, select the placeholder
                            if (!oldFloorId) {
                                $floorSelect.find('option[value=""]').prop('selected', true);
                            }
                        } else {
                            $floorSelect.append('<option value="" disabled selected>No floors available</option>');
                        }
                    },
                    error: function() {
                        $floorSelect.empty();
                        $floorSelect.append('<option value="" disabled selected>No floors available</option>');
                    }
                });

                // Fetch occupancies
                $.ajax({
                    url: `${blockId}/occupancies`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $occupancySelect.empty();

                        if (data.length > 0) {
                            $occupancySelect.append(
                                '<option value="" disabled>Please Choose One</option>');

                            $.each(data, function(index, occupancy) {
                                var selected = (occupancy.id == oldOccupancyId) ? 'selected' : '';
                                $occupancySelect.append(
                                    `<option value="${occupancy.id}" ${selected}>${occupancy.occupancy_type}</option>`
                                );
                            });

                            // If no occupancy is selected, select the placeholder
                            if (!oldOccupancyId) {
                                $occupancySelect.find('option[value=""]').prop('selected', true);
                            }
                        } else {
                            $occupancySelect.append('<option value="" disabled selected>No occupancies available</option>');
                        }
                    },
                    error: function() {
                        $occupancySelect.empty();
                        $occupancySelect.append('<option value="" disabled selected>No occupancies available</option>');
                    }
                });
            });

            // Trigger change if editing existing data
            @if (old('block_id', $room->block_id ?? false))
                $('#block_id').trigger('change');
            @endif
        });
    </script>

    <script>
        $(document).ready(function() {
            const $roomInput = $('#room_number');
            const $roomDisplay = $('#displayRoomNumber');

            $roomInput.on('input', function() {
                $roomDisplay.text($(this).val() || '..');
            });
        });
    </script>
@endsection
