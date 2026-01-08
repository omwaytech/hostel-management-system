@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Resident</h1>
            <ul>
                <li>
                    <a href="{{ route('hostelAdmin.resident.index') }}" class="text-primary">Index</a>
                </li>
                <li>{{ $resident ? 'Edit' : 'Create' }}</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row">
            {{-- @dd(request()) --}}
            @if (request('from_booking'))
                <div class="col-md-12 mb-3">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-info-circle mr-2"></i>Creating Resident from Booking</strong>
                        <p class="mb-0">The form has been pre-filled with data from booking
                            #{{ request('from_booking') }}. Please review and complete the remaining required fields.</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            <form
                action="{{ $resident ? route('hostelAdmin.resident.update', $resident->slug) : route('hostelAdmin.resident.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if ($resident)
                    @method('PUT')
                @endif
                <div class="col-md-12">
                    <div class="card mb-4 bg-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="block_id">
                                        <h6>Hostel Block <code>*</code></h6>
                                    </label>
                                    <select name="block_id" id="block_id"
                                        class="form-control @error('block_id') is-invalid @enderror">
                                        <option value="" disabled
                                            {{ old('block_id', $resident->block_id ?? '') == '' ? 'selected' : '' }}>
                                            Please Choose One</option>

                                        @foreach ($blocks as $block)
                                            <option value="{{ $block->id }}"
                                                {{ old('block_id', $resident->block_id ?? '') == $block->id ? 'selected' : '' }}>
                                                {{ $block->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('block_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>

                                <input type="hidden" id="old_block_id"
                                    value="{{ old('block_id', $resident->bed->room->floor->block_id ?? '') }}">
                                <input type="hidden" id="old_floor_id"
                                    value="{{ old('floor_id', $resident->bed->room->floor_id ?? '') }}">
                                <input type="hidden" id="old_room_id"
                                    value="{{ old('room_id', $resident->bed->room_id ?? '') }}">
                                <input type="hidden" id="old_bed_id" value="{{ old('bed_id', $resident->bed_id ?? '') }}">
                                <input type="hidden" id="old_occupancy_id"
                                    value="{{ old('occupancy_id', request('occupancy_id', $resident->occupancy_id ?? '')) }}">

                                <div class="col-md-3 form-group">
                                    <label for="floor_id">
                                        <h6>Hostel Floor <code>*</code></h6>
                                    </label>
                                    <select name="floor_id" id="floor_id"
                                        class="form-control @error('floor_id') is-invalid @enderror">
                                        <option value="" disabled selected>Please Choose Block First</option>
                                    </select>
                                    @error('floor_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="room_id">
                                        <h6>Hostel Room <code>*</code></h6>
                                    </label>
                                    <select name="room_id" id="room_id"
                                        class="form-control @error('room_id') is-invalid @enderror">
                                        <option value="" disabled selected>Please Choose Floor First</option>
                                    </select>
                                    @error('room_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="bed_id">
                                        <h6>Bed Number <code>*</code></h6>
                                    </label>
                                    <select name="bed_id" id="bed_id"
                                        class="form-control @error('bed_id') is-invalid @enderror">
                                        <option value="" disabled selected>Please Choose Room First</option>
                                    </select>
                                    @error('bed_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="occupancy_id">
                                        <h6>Occupancy / Bed Type <code>*</code></h6>
                                    </label>
                                    <select name="occupancy_id" id="occupancy_id"
                                        class="form-control @error('occupancy_id') is-invalid @enderror">
                                        <option value="" disabled selected>Please Choose Block First</option>
                                    </select>
                                    @error('occupancy_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4 bg-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="full_name">
                                        <h6>Full Name <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                        name="full_name" type="text" placeholder="Enter name"
                                        value="{{ old('full_name', request('full_name', $resident->full_name ?? '')) }}" />
                                    @error('full_name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="email">
                                        <h6>Email <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" type="email" placeholder="Enter email"
                                        value="{{ old('email', request('email', $resident->email ?? '')) }}" />
                                    @error('email')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="contact_number">
                                        <h6>Contact Number <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('contact_number') is-invalid @enderror"
                                        id="contact_number" name="contact_number" type="number" placeholder="Enter number"
                                        value="{{ old('contact_number', request('contact_number', $resident->contact_number ?? '')) }}" />
                                    @error('contact_number')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="guardian_contact">
                                        <h6>Guardian Contact <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('guardian_contact') is-invalid @enderror"
                                        id="guardian_contact" name="guardian_contact" type="number"
                                        placeholder="Enter number"
                                        value="{{ old('guardian_contact', request('guardian_contact', $resident->guardian_contact ?? '')) }}" />
                                    @error('guardian_contact')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>
                                        <h6>Photo <code>*</code></h6>
                                    </label><br>
                                    <div class="d-flex justify-content-center">
                                        @if ($resident && $resident->photo)
                                            <img src="{{ asset('storage/images/residentPhotos/' . $resident->photo) }}"
                                                id="preview" alt="{{ $resident->photo }}"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                        @else
                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                        @endif
                                        <input class="ml-2 mt-2 form-control @error('photo') is-invalid @enderror"
                                            type="file" name="photo" id="photo"
                                            accept="image/jpeg,image/png,image/jpg" value="{{ old('photo') }}"
                                            onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                    @error('photo')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>
                                        <h6>Citizenship (Both Side) <code>*</code></h6>
                                    </label><br>
                                    <div class="d-flex justify-content-center">
                                        @if ($resident && $resident->citizenship)
                                            <img src="{{ asset('storage/images/residentCitizenship/' . $resident->citizenship) }}"
                                                id="preview1" alt="{{ $resident->citizenship }}"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" />
                                        @else
                                            <img src="{{ asset('assets/images/noPreview.jpeg') }}" id="preview1"
                                                style="max-width: 60px; height: auto; border-radius: 9px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"
                                                alt="{{ asset('assets/images/noPreview.jpeg') }}" />
                                        @endif
                                        <input class="ml-2 mt-2 form-control @error('citizenship') is-invalid @enderror"
                                            type="file" name="citizenship" id="citizenship"
                                            accept="image/jpeg,image/png,image/jpg" value="{{ old('citizenship') }}"
                                            onchange="document.getElementById('preview1').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                    @error('citizenship')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="check_in_date">
                                        <h6>Check In Date <code>*</code></h6>
                                    </label>
                                    <input class="form-control @error('check_in_date') is-invalid @enderror"
                                        id="check_in_date" name="check_in_date" type="date"
                                        value="{{ old('check_in_date', request('check_in_date', $resident->check_in_date ?? '')) }}" />
                                    @error('check_in_date')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="check_out_date">
                                        <h6>Check Out Date</h6>
                                    </label>
                                    <input class="form-control @error('check_out_date') is-invalid @enderror"
                                        id="check_out_date" name="check_out_date" type="date"
                                        value="{{ old('check_out_date', $resident->check_out_date ?? '') }}" />
                                    @error('check_out_date')
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const $occupancySelect = $('#occupancy_id');
            const oldOccupancyId = $('#old_occupancy_id').val();

            $('#block_id').on('change', function() {
                const blockId = $(this).val();

                $.ajax({
                    url: `${blockId}/occupancy`, // use full route if needed
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $occupancySelect.empty().append(
                            '<option value="" disabled selected>Please Choose One</option>');

                        $.each(data, function(index, occupancy) {
                            let selected = (occupancy.id == oldOccupancyId) ?
                                'selected' : '';
                            $occupancySelect.append(
                                `<option value="${occupancy.id}" ${selected}>${occupancy.occupancy_type}</option>`
                            );
                        });
                    },
                    error: function() {
                        $occupancySelect.empty().append(
                            '<option value="">No Occupancies available</option>');
                    }
                });
            });

            // Trigger change if block_id is pre-selected
            const oldBlockId = "{{ old('block_id', $resident->block_id ?? '') }}";
            if (oldBlockId) {
                $('#block_id').val(oldBlockId).trigger('change');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            const oldBlockId = $('#old_block_id').val();
            const oldFloorId = $('#old_floor_id').val();
            const oldRoomId = $('#old_room_id').val();
            const oldBedId = $('#old_bed_id').val();

            function fetchFloors(blockId, callback = null) {
                $('#floor_id').empty().append('<option selected disabled>Loading...</option>');
                $('#room_id').empty().append('<option selected disabled>Please Choose Floor First</option>');
                $('#bed_id').empty().append('<option selected disabled>Please Choose Room First</option>');

                $.get(`/hostel/block/${blockId}/floors`, function(floors) {
                    $('#floor_id').empty().append('<option disabled selected>Please Choose One</option>');
                    $.each(floors, function(i, floor) {
                        $('#floor_id').append(
                            `<option value="${floor.id}" ${floor.id == oldFloorId ? 'selected' : ''}>${floor.floor_label}</option>`
                        );
                    });

                    if (callback) callback();
                });
            }

            function fetchRooms(floorId, callback = null) {
                $('#room_id').empty().append('<option selected disabled>Loading...</option>');
                $('#bed_id').empty().append('<option selected disabled>Please Choose Room First</option>');

                $.get(`/hostel/floor/${floorId}/rooms`, function(rooms) {
                    $('#room_id').empty().append('<option disabled selected>Please Choose One</option>');
                    $.each(rooms, function(i, room) {
                        $('#room_id').append(
                            `<option value="${room.id}" ${room.id == oldRoomId ? 'selected' : ''}>${room.room_number}</option>`
                        );
                    });

                    if (callback) callback();
                });
            }

            function fetchBeds(roomId) {
                $('#bed_id').empty().append('<option selected disabled>Loading...</option>');

                $.get(`/hostel/room/${roomId}/beds`, function(beds) {
                    $('#bed_id').empty().append('<option disabled selected>Please Choose One</option>');
                    $.each(beds, function(i, bed) {
                        $('#bed_id').append(
                            `<option value="${bed.id}" ${bed.id == oldBedId ? 'selected' : ''}>${bed.bed_number}</option>`
                        );
                    });
                });
            }

            // Initial load (edit mode)
            if (oldBlockId) {
                $('#block_id').val(oldBlockId);
                fetchFloors(oldBlockId, function() {
                    if (oldFloorId) {
                        $('#floor_id').val(oldFloorId);
                        fetchRooms(oldFloorId, function() {
                            if (oldRoomId) {
                                $('#room_id').val(oldRoomId);
                                fetchBeds(oldRoomId);
                            }
                        });
                    }
                });
            }

            // On-change events
            $('#block_id').on('change', function() {
                const blockId = $(this).val();
                fetchFloors(blockId);
            });

            $('#floor_id').on('change', function() {
                const floorId = $(this).val();
                fetchRooms(floorId);
            });

            $('#room_id').on('change', function() {
                const roomId = $(this).val();
                fetchBeds(roomId);
            });

            // Auto-populate from booking data if room_id is provided in URL
            @if (request('room_id'))
                const roomId = "{{ request('room_id') }}";
                @if (request('occupancy_id'))
                    const occupancyId = "{{ request('occupancy_id') }}";
                @endif

                // Fetch the room details to get block and floor
                $.ajax({
                    url: "{{ url('/hostel/resident/get-room-details') }}/" + roomId,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Set block
                            $('#block_id').val(response.block_id).trigger('change');

                            @if (request('occupancy_id'))
                                // Wait for occupancies to load, then set occupancy
                                setTimeout(function() {
                                    $('#occupancy_id').val(occupancyId);
                                }, 300);
                            @endif

                            // Wait for floors to load, then set floor
                            setTimeout(function() {
                                $('#floor_id').val(response.floor_id).trigger('change');

                                // Wait for rooms to load, then set room
                                setTimeout(function() {
                                    $('#room_id').val(roomId).trigger('change');
                                }, 500);
                            }, 500);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching room details:', xhr);
                    }
                });
            @endif
        });
    </script>
@endsection
