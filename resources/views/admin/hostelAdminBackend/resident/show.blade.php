@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>User Profile</h1>
        <ul>
            <li><a href="{{ route('hostelAdmin.resident.index') }}" class="text-primary">Index</a></li>
            <li>User Profile</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card user-profile o-hidden mb-4">
        {{-- <div class="header-cover"
            style="background-image: url('{{ asset('storage/images/hostelLogos/' . $resident->block->hostel->logo) }}'); background-position: top; background-repeat: no-repeat; background-size: cover;">
        </div> --}}
        <div class="user-info mt-4 mb-4">
            <img class="profile-picture avatar-lg mb-2" src="{{ asset('storage/images/residentPhotos/' . $resident->photo) }}"
                alt="Resident Photo" />
            <p class="m-0 text-24"><strong>{{ $resident->full_name }}</strong></p>
        </div>
        <ul class="nav nav-tabs profile-nav mb-4" id="profileTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="about-tab" data-toggle="tab" href="#about" role="tab"
                    aria-controls="about" aria-selected="true">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="bed-transfer-tab" data-toggle="tab" href="#bedTransfer" role="tab"
                    aria-controls="bedTransfer" aria-selected="false">Bed Transfer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab"
                    aria-controls="payment" aria-selected="false">Payment</a>
            </li>
        </ul>
        <div class="tab-content" id="profileTabContent">
            <div class="tab-pane fade active show" id="about" role="tabpanel" aria-labelledby="about-tab">
                <div class="col-md-12 border-right pr-4">
                    <h4 class="mb-4 text-center"><strong>Resident Information</strong></h4>
                    <hr />
                    <div class="row ml-2">
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i> Contact Number</p>
                            <span>{{ $resident->contact_number }}</span>

                            <p class="text-primary mb-1 mt-3"><i class="i-MaleFemale text-16 mr-1"></i> Guardian Contact
                            </p>
                            <span>{{ $resident->guardian_contact }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-Face-Style-4 text-16 mr-1"></i> Check In Date</p>
                            <span>{{ $resident->check_in_date }}</span>

                            <p class="text-primary mb-1 mt-3"><i class="i-Face-Style-4 text-16 mr-1"></i> Check Out Date
                            </p>
                            <span>{{ $resident->check_out_date ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-Face-Style-4 text-16 mr-1"></i> Hostel Block</p>
                            <span>{{ $resident->block->name }}</span>

                            <p class="text-primary mb-1 mt-3"><i class="i-Face-Style-4 text-16 mr-1"></i> Hostel Floor
                            </p>
                            <span>{{ $resident->bed->room->floor->floor_label ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-Face-Style-4 text-16 mr-1"></i> Hostel Room Number
                            </p>
                            <span>{{ $resident->bed->room->room_number ?? 'N/A' }}</span>

                            <p class="text-primary mb-1 mt-3"><i class="i-Face-Style-4 text-16 mr-1"></i> Hostel Bed
                                Number</p>
                            <span>{{ $resident->bed->bed_number ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> ID</p>
                            <span>
                                <img src="{{ asset('storage/images/residentCitizenship/' . $resident->citizenship) }}"
                                    alt="ID" class="img-thumbnail"
                                    style="max-width: 120px; cursor: pointer; border-radius: 20px;" data-toggle="modal"
                                    data-target="#citizenshipModal">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="bedTransfer" role="tabpanel" aria-labelledby="bed-transfer-tab">
                <div class="col-md-12 pl-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0"><strong>Bed Transfer History</strong></h4>
                        <div>
                            <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#bedTransferModal">
                                <i class="i-Repeat-3 mr-1"></i> Change Bed (Same Hostel)
                            </button>
                            <button class="btn btn-success" data-toggle="modal" data-target="#hostelTransferModal">
                                <i class="i-Home1 mr-1"></i> Transfer to Another Hostel
                            </button>
                        </div>
                    </div>
                    <hr />

                    <!-- Scrollable container -->
                    <div class="col-md-12"
                        style="max-height: 400px; overflow-y: auto; padding-right: 6px; padding-left: 6px;">
                        @if ($resident->bedTransfers)
                            @foreach ($resident->bedTransfers->sortByDesc('created_at') as $transfer)
                                <div class="timeline-card card mb-3">
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <strong>Date: {{ $transfer->transfer_date }}</strong>
                                        </div>
                                        <div class="ml-1">
                                            <p>
                                                <i class="fas fa-minus mr-1"></i>
                                                <strong>From</strong><br> Block
                                                {{ $transfer->fromBed->room->floor->block->name ?? '' }} -
                                                Room {{ $transfer->fromBed->room->room_number ?? '' }} -
                                                Bed {{ $transfer->fromBed->bed_number ?? '' }}
                                                <br><br>
                                                <i class="fas fa-minus mr-1"></i>
                                                <strong>To</strong><br> Block
                                                {{ $transfer->toBed->room->floor->block->name ?? '' }} -
                                                Room {{ $transfer->toBed->room->room_number ?? '' }} -
                                                Bed {{ $transfer->toBed->bed_number ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div>No Transfers Found</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                <div class="col-md-12">
                    <h4 class="mb-0 text-center"><strong>Resident Payment History</strong></h4>
                    <hr />
                    {{-- @if ($resident->rentPayments->count() <= 1) --}}
                    <div class="row">
                        @foreach ($resident->rentPayments as $payment)
                            <div class="col-md-4">
                                <div class="card" style="color: green">
                                    <div class="card-body">
                                        <div class="timeline-item">
                                            <a href="{{ route('hostelAdmin.bill.show', $payment->bill->slug) }}">
                                                <div class="timeline-content">
                                                    <h4 class="mb-1">Paid rent of
                                                        <h3 class="text-success">
                                                            Rs. {{ number_format($payment->amount_paid, 2) }}
                                                        </h3>
                                                    </h4>
                                                    <div class="timeline-date">
                                                        <h5>Month:
                                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('M') }}
                                                            -
                                                            Via:
                                                            {{ $payment->method ?? 'Cash' }}
                                                        </h5>
                                                    </div>
                                                    <div class="text-muted small">Invoice ID:
                                                        #{{ $payment->bill->invoice_number ?? 'N/A' }}</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- @else
                        <div>No recent payments</div>
                    @endif --}}

                </div>
            </div>
        </div>
    </div>

    <!-- Citizenship Modal -->
    <div class="modal fade" id="citizenshipModal" tabindex="-1" role="dialog" aria-labelledby="citizenshipModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="{{ asset('storage/images/residentCitizenship/' . $resident->citizenship) }}"
                        alt="Full ID Image" class="img-fluid mb-3">

                    <div class="mt-3">
                        <a href="{{ asset('storage/images/residentCitizenship/' . $resident->citizenship) }}"
                            class="btn btn-primary" download>
                            Download
                        </a>
                        <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bed Transfer Modal -->
    <div class="modal fade" id="bedTransferModal" tabindex="-1" role="dialog" aria-labelledby="bedTransferModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('hostelAdmin.resident.bedTransfer') }}" method="POST">
                @csrf
                <input type="hidden" name="resident_id" value="{{ $resident->id }}">
                <input type="hidden" name="from_bed_id" value="{{ $resident->bed_id }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bedTransferModalLabel">Change Bed</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Resident:</strong> {{ $resident->full_name }}</p>
                        <input type="hidden" name="resident_id" id="resident_id" value="{{ $resident->id }}" readonly>
                        <p><strong>Current Bed:</strong> {{ $resident->bed->bed_number ?? 'N/A' }}</p>
                        <input type="hidden" name="from_bed_id" id="from_bed_id" value="{{ $resident->bed->id }}"
                            readonly>
                        <div class="separator-breadcrumb border-top"></div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select Block</h6>
                                </label>
                                <select id="block_id" name="block_id" class="form-control" required>
                                    <option value="" selected disabled>Please Choose Block</option>
                                    @foreach ($blocks as $block)
                                        <option value="{{ $block->id }}">{{ $block->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select Floor</h6>
                                </label>
                                <select id="floor_id" class="form-control" required disabled>
                                    <option value="" selected disabled>Please Choose Floor First</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select Room</h6>
                                </label>
                                <select id="room_id" class="form-control" required disabled>
                                    <option value="" selected disabled>Please Choose Floor First</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select New Bed</h6>
                                </label>
                                <select name="to_bed_id" id="bed_id" class="form-control" required disabled>
                                    <option value="" selected disabled>Please Choose Room First</option>
                                </select>
                            </div>
                        </div>
                        <div class="separator-breadcrumb border-top"></div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>
                                    <h6>Occupancy / Bed Type</h6>
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
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Transfer</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Cross-Hostel Transfer Modal -->
    <div class="modal fade" id="hostelTransferModal" tabindex="-1" role="dialog"
        aria-labelledby="hostelTransferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('hostelAdmin.resident.bedTransfer') }}" method="POST">
                @csrf
                <input type="hidden" name="resident_id" value="{{ $resident->id }}">
                <input type="hidden" name="from_bed_id" value="{{ $resident->bed_id }}">

                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="hostelTransferModalLabel">
                            <i class="i-Home1 mr-2"></i>Transfer Resident to Another Hostel
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Current Information -->
                        <div class="alert alert-info">
                            <strong>Current Location:</strong><br>
                            <strong>Hostel</strong>: {{ $resident->bed->room->floor->block->hostel->name ?? 'N/A' }}
                            <strong>Block</strong> {{ $resident->bed->room->floor->block->name ?? 'N/A' }}
                            <strong>Room</strong> {{ $resident->bed->room->room_number ?? 'N/A' }} |
                            <strong>Bed</strong> {{ $resident->bed->bed_number ?? 'N/A' }}
                        </div>

                        <div class="separator-breadcrumb border-top mb-3"></div>
                        {{-- <h6 class="text-primary mb-3"><strong>Select New Location</strong></h6> --}}

                        <div class="row">
                            <!-- Hostel Selection -->
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select Hostel <span class="text-danger">*</span></h6>
                                </label>
                                <select id="hostel_transfer_hostel_id" class="form-control" required>
                                    <option value="" selected disabled>Choose Hostel</option>
                                    @foreach ($allHostels as $hostel)
                                        <option value="{{ $hostel->id }}">{{ $hostel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Block Selection -->
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select Block <span class="text-danger">*</span></h6>
                                </label>
                                <select id="hostel_transfer_block_id" name="block_id" class="form-control" required
                                    disabled>
                                    <option value="" selected disabled>Choose Hostel First</option>
                                </select>
                            </div>

                            <!-- Floor Selection -->
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select Floor <span class="text-danger">*</span></h6>
                                </label>
                                <select id="hostel_transfer_floor_id" class="form-control" required disabled>
                                    <option value="" selected disabled>Choose Block First</option>
                                </select>
                            </div>

                            <!-- Room Selection -->
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select Room <span class="text-danger">*</span></h6>
                                </label>
                                <select id="hostel_transfer_room_id" class="form-control" required disabled>
                                    <option value="" selected disabled>Choose Floor First</option>
                                </select>
                            </div>

                            <!-- Bed Selection -->
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Select Bed <span class="text-danger">*</span></h6>
                                </label>
                                <select name="to_bed_id" id="hostel_transfer_bed_id" class="form-control" required
                                    disabled>
                                    <option value="" selected disabled>Choose Room First</option>
                                </select>
                            </div>

                            <!-- Occupancy Type Selection -->
                            <div class="col-md-6 form-group">
                                <label>
                                    <h6>Occupancy / Bed Type <span class="text-danger">*</span></h6>
                                </label>
                                <select name="occupancy_id" id="hostel_transfer_occupancy_id" class="form-control"
                                    required disabled>
                                    <option value="" disabled selected>Choose Block First</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="i-Information mr-2"></i>
                            <strong>Note:</strong> Transferring to another hostel will update the resident's check-out date
                            for the current hostel and set a new check-in date for the new hostel.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="i-Yes mr-1"></i> Confirm Transfer
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="i-Close mr-1"></i> Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script>
        $(document).ready(function() {
            const oldBlockId = "{{ old('block_id', $resident->block->id ?? '') }}";
            const oldFloorId = "{{ old('floor_id', $resident->bed->room->floor->id ?? '') }}";
            const oldRoomId = "{{ old('room_id', $resident->bed->room->id ?? '') }}";
            const oldBedId = "{{ old('to_bed_id', $transfer->to_bed_id ?? '') }}";
            const oldOccupancyId = "{{ old('occupancy_id', $resident->occupancy->id ?? '') }}";

            // When block is selected
            $('#block_id').on('change', function() {
                let blockId = $(this).val();

                // Load Floors
                $('#floor_id').html('<option selected disabled>Loading...</option>').prop('disabled', true);
                $.get(`/hostel/block/${blockId}/floors`, function(floors) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    floors.forEach(floor => {
                        options +=
                            `<option value="${floor.id}" ${floor.id == oldFloorId ? 'selected' : ''}>${floor.floor_label}</option>`;
                    });
                    $('#floor_id').html(options).prop('disabled', false);
                });

                // Load Occupancy
                let $occupancySelect = $('#occupancy_id');
                $occupancySelect.html('<option selected disabled>Loading...</option>');
                $.get(`${blockId}/occupancy`, function(data) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    data.forEach(function(occ) {
                        options +=
                            `<option value="${occ.id}">${occ.occupancy_type}</option>`;
                    });
                    $occupancySelect.html(options);
                });
            });

            // When floor is selected
            $('#floor_id').on('change', function() {
                let floorId = $(this).val();
                $('#room_id').html('<option selected disabled>Loading...</option>').prop('disabled', true);
                $.get(`/hostel/floor/${floorId}/rooms`, function(rooms) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    rooms.forEach(room => {
                        options +=
                            `<option value="${room.id}">${room.room_number}</option>`;
                    });
                    $('#room_id').html(options).prop('disabled', false);
                });
            });

            // When room is selected
            $('#room_id').on('change', function() {
                let roomId = $(this).val();
                $('#bed_id').html('<option selected disabled>Loading...</option>').prop('disabled', true);
                $.get(`/hostel/room/${roomId}/beds`, function(beds) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    beds.forEach(bed => {
                        options +=
                            `<option value="${bed.id}">Bed ${bed.bed_number}</option>`;
                    });
                    $('#bed_id').html(options).prop('disabled', false);
                });
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            const oldBlockId = "{{ old('block_id', $resident->block->id ?? '') }}";
            const oldFloorId = "{{ old('floor_id', $resident->bed->room->floor->id ?? '') }}";
            const oldRoomId = "{{ old('room_id', $resident->bed->room->id ?? '') }}";
            const oldBedId = "{{ old('to_bed_id', $transfer->to_bed_id ?? '') }}";
            const oldOccupancyId = "{{ old('occupancy_id', $resident->occupancy->id ?? '') }}";

            function loadFloors(blockId, callback) {
                $('#floor_id').html('<option selected disabled>Loading...</option>').prop('disabled', true);
                $.get(`/hostel/block/${blockId}/floors`, function(floors) {
                    let options = '<option disabled selected>Please Choose One</option>';
                    floors.forEach(floor => {
                        options +=
                            `<option value="${floor.id}" ${floor.id == oldFloorId ? 'selected' : ''}>${floor.floor_label}</option>`;
                    });
                    $('#floor_id').html(options).prop('disabled', false);
                    if (callback) callback();
                });
            }

            function loadRooms(floorId, callback) {
                $('#room_id').html('<option selected disabled>Loading...</option>').prop('disabled', true);
                $.get(`/hostel/floor/${floorId}/rooms`, function(rooms) {
                    let options = '<option disabled selected>Please Choose One</option>';
                    rooms.forEach(room => {
                        options +=
                            `<option value="${room.id}" ${room.id == oldRoomId ? 'selected' : ''}>${room.room_number}</option>`;
                    });
                    $('#room_id').html(options).prop('disabled', false);
                    if (callback) callback();
                });
            }

            function loadBeds(roomId) {
                $('#bed_id').html('<option selected disabled>Loading...</option>').prop('disabled', true);
                $.get(`/hostel/room/${roomId}/beds`, function(beds) {
                    let options = '<option disabled selected>Please Choose One</option>';
                    beds.forEach(bed => {
                        options +=
                            `<option value="${bed.id}" ${bed.id == oldBedId ? 'selected' : ''}>Bed ${bed.bed_number}</option>`;
                    });
                    $('#bed_id').html(options).prop('disabled', false);
                });
            }

            function loadOccupancy(blockId) {
                $('#occupancy_id').html('<option selected disabled>Loading...</option>');
                $.get(`${blockId}/occupancy`, function(data) {
                    let options = '<option disabled selected>Please Choose One</option>';
                    data.forEach(occ => {
                        options +=
                            `<option value="${occ.id}" ${occ.id == oldOccupancyId ? 'selected' : ''}>${occ.occupancy_type}</option>`;
                    });
                    $('#occupancy_id').html(options);
                });
            }

            // On block change
            $('#block_id').on('change', function() {
                const blockId = $(this).val();
                loadFloors(blockId);
                loadOccupancy(blockId);
            });

            // On floor change
            $('#floor_id').on('change', function() {
                const floorId = $(this).val();
                loadRooms(floorId);
            });

            // On room change
            $('#room_id').on('change', function() {
                const roomId = $(this).val();
                loadBeds(roomId);
            });

            // Prefill if values exist
            if (oldBlockId) {
                $('#block_id').val(oldBlockId);
                loadFloors(oldBlockId, function() {
                    if (oldFloorId) {
                        $('#floor_id').val(oldFloorId);
                        loadRooms(oldFloorId, function() {
                            if (oldRoomId) {
                                $('#room_id').val(oldRoomId);
                                loadBeds(oldRoomId);
                            }
                        });
                    }
                });
                loadOccupancy(oldBlockId);
            }

            // ============================================
            // Cross-Hostel Transfer Modal JavaScript
            // ============================================

            // When hostel is selected
            $('#hostel_transfer_hostel_id').on('change', function() {
                let hostelId = $(this).val();

                // Load Blocks for selected hostel
                $('#hostel_transfer_block_id').html('<option selected disabled>Loading...</option>').prop(
                    'disabled', true);
                $.get(`/hostel/hostel/${hostelId}/blocks`, function(blocks) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    blocks.forEach(block => {
                        options +=
                            `<option value="${block.id}">${block.name} - Block ${block.block_number}</option>`;
                    });
                    $('#hostel_transfer_block_id').html(options).prop('disabled', false);
                });
            });

            // When block is selected in hostel transfer
            $('#hostel_transfer_block_id').on('change', function() {
                let blockId = $(this).val();

                // Load Floors
                $('#hostel_transfer_floor_id').html('<option selected disabled>Loading...</option>').prop(
                    'disabled', true);
                $.get(`/hostel/block/${blockId}/floors`, function(floors) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    floors.forEach(floor => {
                        options +=
                            `<option value="${floor.id}">${floor.floor_label}</option>`;
                    });
                    $('#hostel_transfer_floor_id').html(options).prop('disabled', false);
                });

                // Load Occupancy
                $('#hostel_transfer_occupancy_id').html('<option selected disabled>Loading...</option>')
                    .prop('disabled', true);
                $.get(`/hostel/resident/${blockId}/occupancy`, function(occupancies) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    occupancies.forEach(occ => {
                        options +=
                            `<option value="${occ.id}">${occ.occupancy_type}</option>`;
                    });
                    $('#hostel_transfer_occupancy_id').html(options).prop('disabled', false);
                });
            });

            // When floor is selected in hostel transfer
            $('#hostel_transfer_floor_id').on('change', function() {
                let floorId = $(this).val();

                $('#hostel_transfer_room_id').html('<option selected disabled>Loading...</option>').prop(
                    'disabled', true);
                $.get(`/hostel/floor/${floorId}/rooms`, function(rooms) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    rooms.forEach(room => {
                        options +=
                            `<option value="${room.id}">Room ${room.room_number}</option>`;
                    });
                    $('#hostel_transfer_room_id').html(options).prop('disabled', false);
                });
            });

            // When room is selected in hostel transfer
            $('#hostel_transfer_room_id').on('change', function() {
                let roomId = $(this).val();

                $('#hostel_transfer_bed_id').html('<option selected disabled>Loading...</option>').prop(
                    'disabled', true);
                $.get(`/hostel/room/${roomId}/beds`, function(beds) {
                    let options = '<option selected disabled>Please Choose One</option>';
                    beds.forEach(bed => {
                        options +=
                            `<option value="${bed.id}">Bed ${bed.bed_number}</option>`;
                    });
                    $('#hostel_transfer_bed_id').html(options).prop('disabled', false);
                });
            });
        });
    </script>
@endsection
