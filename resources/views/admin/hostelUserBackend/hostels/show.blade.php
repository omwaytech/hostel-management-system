@extends('admin.layouts.hostelUserBackend')

@section('page-title', 'Hostel Details')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('resident.dashboard') }}">Dashboard</a>
    </li>
    <li>
        <a href="{{ route('resident.hostels') }}">All Hostels</a>
    </li>
    <li>{{ $hostel->name }}</li>
@endsection

@section('content')
    <div class="row">
        <!-- Hostel Header Card -->
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    @if ($hostel->logo)
                        <img src="{{ asset('storage/images/hostelLogos/' . $hostel->logo) }}" alt="{{ $hostel->name }}"
                            style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;" class="mb-3">
                    @endif
                    <h3 class="text-primary mb-1">{{ $hostel->name }}</h3>
                    @if ($currentBed)
                        <p class="text-muted">
                            {{ $currentBed->room->floor->block->name }} Block
                            {{ $currentBed->room->floor->block->block_number }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Room Information -->
        @if ($currentBed)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ntext-primary mr-2"></i>Room Information
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Block:</strong></td>
                                    <td>{{ $currentBed->room->floor->block->name ?? 'N/A' }}
                                        Block {{ $currentBed->room->floor->block->block_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Floor:</strong></td>
                                    <td>{{ $currentBed->room->floor->floor_label ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Room Number:</strong></td>
                                    <td>{{ $currentBed->room->room_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bed Number:</strong></td>
                                    <td>{{ $currentBed->bed_number ?? 'N/A' }}</td>
                                </tr>
                                @if ($currentBed->room->occupancy)
                                    <tr>
                                        <td><strong>Occupancy Type:</strong></td>
                                        <td>{{ $currentBed->room->occupancy->occupancy_type ?? 'N/A' }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stay Information -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="text-success mr-2"></i>Stay Information
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Check-in Date:</strong></td>
                                <td>{{ $resident->check_in_date ? \Carbon\Carbon::parse($resident->check_in_date)->format('M d, Y') : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Check-out Date:</strong></td>
                                <td>{{ $resident->check_out_date ? \Carbon\Carbon::parse($resident->check_out_date)->format('M d, Y') : 'Ongoing' }}
                                </td>
                            </tr>
                            {{-- @if ($resident->check_in_date)
                                <tr>
                                    <td><strong>Duration:</strong></td>
                                    <td>
                                        @php
                                            $checkIn = \Carbon\Carbon::parse($resident->check_in_date);
                                            $checkOut = $resident->check_out_date
                                                ? \Carbon\Carbon::parse($resident->check_out_date)
                                                : \Carbon\Carbon::now();
                                            $duration = $checkIn->diffInDays($checkOut);
                                        @endphp
                                        {{ $duration }} days
                                    </td>
                                </tr>
                            @endif --}}
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if ($resident->block->hostel['status'] == 'Current')
                                        <span class="badge badge-success">Current</span>
                                    @else
                                        <span class="badge badge-secondary">Past</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bed Transfer History -->
        @if ($hostelBedTransfers && $hostelBedTransfers->count() > 0)
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="text-warning mr-2"></i>Bed Transfer History in {{ $hostel->name }}
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>From</th>
                                        <th>To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hostelBedTransfers->sortByDesc('created_at') as $transfer)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($transfer->transfer_date)->format('M d, Y') }}
                                            </td>
                                            <td>
                                                <strong>Block:</strong>
                                                {{ $transfer->fromBed->room->floor->block->name ?? 'N/A' }}
                                                {{ $transfer->fromBed->room->floor->block->block_number ?? 'N/A' }}<br>
                                                <strong>Room:</strong>
                                                {{ $transfer->fromBed->room->room_number ?? 'N/A' }}<br>
                                                <strong>Bed:</strong> {{ $transfer->fromBed->bed_number ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <strong>Block:</strong>
                                                {{ $transfer->toBed->room->floor->block->name ?? 'N/A' }}
                                                {{ $transfer->toBed->room->floor->block->block_number ?? 'N/A' }}<br>
                                                <strong>Room:</strong>
                                                {{ $transfer->toBed->room->room_number ?? 'N/A' }}<br>
                                                <strong>Bed:</strong> {{ $transfer->toBed->bed_number ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-body text-center py-4">
                        <i class="i-Information text-muted" style="font-size: 32px;"></i>
                        <p class="text-muted mt-2">No bed transfers recorded for this hostel.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Payment History -->
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="text-info mr-2"></i>Payment History
                    </h5>

                    {{-- <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h6>Due Amount</h6>
                                    <h3>NPR {{ number_format($resident->due_amount ?? 0, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6>Advance Payment</h6>
                                    <h3>NPR {{ number_format($resident->advance_rent_payment ?? 0, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    @if ($hostelPayments && $hostelPayments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Payment Date</th>
                                        <th>Generated By</th>
                                        <th>Amount Paid</th>
                                        <th>Payment Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hostelPayments->sortByDesc('created_at') as $payment)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                            <td>{{ $payment->bill->generated_by ?? 'N/A' }}</td>
                                            <td><strong>NPR {{ number_format($payment->amount_paid, 2) }}</strong></td>
                                            <td>{{ $payment->bill->payment_method ?? 'Cash' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="i-Information text-muted" style="font-size: 32px;"></i>
                            <p class="text-muted mt-2">No payment records available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Back Button -->
        {{-- <div class="col-lg-12">
            <a href="{{ route('resident.hostels') }}" class="btn btn-secondary">
                <i class="i-Arrow-Left mr-1"></i> Back to All Hostels
            </a>
        </div> --}}
    </div>
@endsection
