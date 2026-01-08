@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{ $currentHostel->name }} Blocks</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.booking.index') }}" class="text-primary">Index</a></li>
                <li>Bookings</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-end mb-3">
                            <div class="clearfix mr-3">
                                <a href="{{ route('hostelAdmin.booking.create') }}" class="btn btn-success">
                                    <i class="nav-icon fas fa-plus"></i> Add New
                                </a>
                            </div>
                        </div> --}}
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Booking Name</th>
                                        <th>Booking Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $booking->full_name }}</td>
                                            <td>{{ $booking->email }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-info mr-1 view-booking" data-toggle="modal"
                                                        data-target="#bookingModal{{ $booking->slug }}">
                                                        <i class="nav-icon fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-danger delete-booking"
                                                        data-slug="{{ $booking->slug }}">
                                                        <i class="nav-icon fas fa-trash"></i>
                                                    </button>
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

    <!-- Booking Details Modals -->
    @foreach ($bookings as $booking)
        <div class="modal fade" id="bookingModal{{ $booking->slug }}" tabindex="-1" role="dialog"
            aria-labelledby="bookingModalLabel{{ $booking->slug }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="bookingModalLabel{{ $booking->slug }}">
                            Booking Details - #{{ $booking->slug }}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Guest Information -->
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-header ">
                                        <h6 class="mb-0 font-weight-bold ">
                                            <i class="fas fa-user mr-2"></i>Guest Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Full Name</small>
                                            <strong>{{ $booking->full_name }}</strong>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Email</small>
                                            <strong>{{ $booking->email }}</strong>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Phone</small>
                                            <strong>{{ $booking->phone }}</strong>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Current Address</small>
                                            <strong>{{ $booking->current_address }}</strong>
                                        </div>
                                        <div class="mb-0">
                                            <small class="text-muted d-block">Emergency Contact</small>
                                            <strong>{{ $booking->emergency_contact }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stay Details -->
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-header ">
                                        <h6 class="mb-0 font-weight-bold ">
                                            <i class="fas fa-calendar-alt mr-2"></i>Stay Details
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Move-in Date</small>
                                            <strong>{{ \Carbon\Carbon::parse($booking->move_in_date)->format('F d, Y') }}</strong>
                                        </div>
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Duration</small>
                                            <strong>{{ $booking->duration }} month(s)</strong>
                                        </div>
                                        <div class="mb-0">
                                            <small class="text-muted d-block">Number of Occupants</small>
                                            <strong>{{ $booking->occupant_count }} person(s)</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                @if ($booking->dietary_preferences || $booking->additional_requests)
                                    <div class="card border-0 shadow-sm mb-3">
                                        <div class="card-header ">
                                            <h6 class="mb-0 font-weight-bold ">
                                                <i class="fas fa-info-circle mr-2"></i>Additional Information
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @if ($booking->dietary_preferences)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Dietary Preferences</small>
                                                    <p class="mb-0">{{ $booking->dietary_preferences }}</p>
                                                </div>
                                            @endif
                                            @if ($booking->additional_requests)
                                                <div class="mb-0">
                                                    <small class="text-muted d-block">Additional Requests</small>
                                                    <p class="mb-0">{{ $booking->additional_requests }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Room Information -->
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-header ">
                                        <h6 class="mb-0 font-weight-bold ">
                                            <i class="fas fa-bed mr-2"></i>Room Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if ($booking->room)
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Room Number</small>
                                                <strong>{{ $booking->room->room_number }}</strong>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Room Type</small>
                                                <strong>
                                                    @if ($booking->room->occupancy)
                                                        {{ $booking->room->occupancy->occupancy_type }} Shared
                                                    @else
                                                        Standard
                                                    @endif
                                                </strong>
                                            </div>
                                            @if ($booking->room->floor && $booking->room->floor->block)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Block</small>
                                                    <strong>{{ $booking->room->floor->block->name }}</strong>
                                                </div>
                                                <div class="mb-0">
                                                    <small class="text-muted d-block">Location</small>
                                                    <strong>{{ $booking->room->floor->block->location }}</strong>
                                                </div>
                                            @endif
                                        @else
                                            <p class="text-muted mb-0">Room information not available</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Payment Summary -->
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-header ">
                                        <h6 class="mb-0 font-weight-bold ">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Payment Summary
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <small class="text-muted">Monthly Rent:</small>
                                            <strong>NPR {{ number_format($booking->monthly_rent, 2) }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <small class="text-muted">Security Deposit:</small>
                                            <strong>NPR {{ number_format($booking->security_deposit, 2) }}</strong>
                                        </div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between mb-2">
                                            <strong class="">Total Amount:</strong>
                                            <strong class="text-success h5 mb-0">NPR
                                                {{ number_format($booking->total_amount, 2) }}</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">Payment Method:</small>
                                            <strong>{{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Booking Status -->
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header ">
                                        <h6 class="mb-0 font-weight-bold ">
                                            <i class="fas fa-check-circle mr-2"></i>Booking Status
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Status</small>
                                            <span
                                                class="badge badge-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'success' : 'danger') }} px-3 py-1">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        <div class="mb-0">
                                            <small class="text-muted d-block">Booking Date</small>
                                            <strong>{{ $booking->created_at->format('F d, Y h:i A') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Close
                        </button>
                        @if (!$booking->resident)
                            <a href="{{ route('hostelAdmin.resident.create', [
                                'from_booking' => $booking->slug,
                                'full_name' => $booking->full_name,
                                'email' => $booking->email,
                                'contact_number' => $booking->phone,
                                'guardian_contact' => $booking->emergency_contact,
                                'check_in_date' => $booking->move_in_date,
                                'room_id' => $booking->room_id,
                                'occupancy_id' => $booking->room && $booking->room->occupancy ? $booking->room->occupancy->id : null,
                            ]) }}"
                                class="btn btn-primary">
                                <i class="fas fa-user-plus mr-1"></i>Proceed to Create Resident
                            </a>
                        @else
                            <span class="badge badge-success px-2 py-2">
                                <i class="fas fa-check-circle mr-1"></i>Resident Already Created
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            deleteAction('.delete-booking', 'hostel/booking');
        });
    </script>
@endsection
