@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Short Term Bookings</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.short-term-bookings.index') }}" class="text-primary">Index</a></li>
                <li>Short Term Bookings</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Room Number</th>
                                        <th>Status</th>
                                        <th>Booking Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $booking->name }}</td>
                                            <td>{{ $booking->email }}</td>
                                            <td>{{ $booking->phone }}</td>
                                            <td>{{ $booking->room ? $booking->room->floor->block->name : 'N/A' }} Room
                                                Number {{ $booking->room ? $booking->room->room_number : 'N/A' }}</td>
                                            <td>
                                                <select class="form-control status-dropdown"
                                                    data-slug="{{ $booking->slug }}" style="width: 140px;">
                                                    <option value="pending"
                                                        {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="confirmed"
                                                        {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                                    </option>
                                                    {{-- <option value="cancelled"
                                                        {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                    </option> --}}
                                                    <option value="completed"
                                                        {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed
                                                    </option>
                                                </select>
                                            </td>
                                            <td>{{ $booking->created_at ? $booking->created_at->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-info mr-1 view-booking"
                                                        data-slug="{{ $booking->slug }}">
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

    <!-- Booking Details Modal -->
    <div class="modal fade" id="bookingDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="bookingDetailsModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingDetailsModalLabel">
                        Booking Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="bookingDetailsContent">
                        <div class="text-center py-4">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            deleteAction('.delete-booking', 'hostel/short-term-bookings');

            // Store original status values
            $('.status-dropdown').each(function() {
                $(this).data('original-status', $(this).val());
            });

            // Manual close handlers for modal
            $(document).on('click', '[data-dismiss="modal"]', function() {
                $('#bookingDetailsModal').modal('hide');
            });

            // Close modal when clicking backdrop
            $('#bookingDetailsModal').on('click', function(e) {
                if ($(e.target).is('#bookingDetailsModal')) {
                    $(this).modal('hide');
                }
            });

            // Handle view booking button
            $(document).on('click', '.view-booking', function() {
                const slug = $(this).data('slug');

                // Show modal with loading state
                $('#bookingDetailsModal').modal('show');
                $('#bookingDetailsContent').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                `);

                // Fetch booking details
                $.ajax({
                    url: `/hostel/short-term-bookings/${slug}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            const statusBadge = {
                                'Pending': 'badge-warning',
                                'Confirmed': 'badge-success',
                                'Cancelled': 'badge-danger',
                                'Completed': 'badge-info'
                            } [data.status] || 'badge-secondary';

                            $('#bookingDetailsContent').html(`
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <th style="width: 35%;">
                                                    <i class="fas fa-user mr-2"></i>Full Name
                                                </th>
                                                <td>${data.name}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-envelope mr-2"></i>Email Address
                                                </th>
                                                <td>${data.email}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-phone mr-2"></i>Phone Number
                                                </th>
                                                <td>${data.phone}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-map-marker-alt mr-2"></i>Permanent Address
                                                </th>
                                                <td>${data.permanent_address}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-calendar-day mr-2"></i>Days of Stay
                                                </th>
                                                <td>${data.days_of_stay}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-bed mr-2"></i>Room Type
                                                </th>
                                                <td>${data.room_type}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-dollar-sign mr-2"></i>Price Range
                                                </th>
                                                <td>${data.price_range}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-door-open mr-2"></i>Assigned Room
                                                </th>
                                                <td><strong>${data.room}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-bed mr-2"></i>Assigned Bed
                                                </th>
                                                <td><strong>${data.bed}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-info-circle mr-2"></i>Status
                                                </th>
                                                <td><span class="badge ${statusBadge} badge-lg">${data.status}</span></td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-calendar mr-2"></i>Booking Date
                                                </th>
                                                <td>${data.booking_date}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <i class="fas fa-comment-alt mr-2"></i>Message
                                                </th>
                                                <td>${data.message}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            `);
                        }
                    },
                    error: function(xhr) {
                        $('#bookingDetailsContent').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                Failed to load booking details. Please try again.
                            </div>
                        `);
                    }
                });
            });

            // Handle status change using event delegation
            $(document).on('change', '.status-dropdown', function() {
                const slug = $(this).data('slug');
                const status = $(this).val();
                const dropdown = $(this);
                const originalStatus = dropdown.data('original-status');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to update the booking status?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/hostel/short-term-bookings/${slug}/update-status`,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: status
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Updated!',
                                    response.message,
                                    'success'
                                );
                                // Update the original status
                                dropdown.data('original-status', status);
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON?.message ||
                                    'Failed to update status.',
                                    'error'
                                );
                                // Revert to original status
                                dropdown.val(originalStatus);
                            }
                        });
                    } else {
                        // User cancelled, revert to original status
                        dropdown.val(originalStatus);
                    }
                });
            });
        });
    </script>
@endsection
