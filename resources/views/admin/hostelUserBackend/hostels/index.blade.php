@extends('admin.layouts.hostelUserBackend')

@section('page-title', 'All Hostels')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('resident.dashboard') }}">Dashboard</a>
    </li>
    <li>All Hostels</li>
@endsection

@section('content')
    <div class="row">
        {{-- <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="i-Home1 text-primary mr-2"></i>
                        Hostels You've Lived In
                    </h5>
                    <p class="text-muted">Click on any hostel to view detailed information about your stay</p>
                </div>
            </div>
        </div> --}}

        @if ($hostels && $hostels->count() > 0)
            @foreach ($hostels as $hostel)
                <div class="col-lg-6 col-md-6 mb-4">
                    <a href="{{ route('resident.hostels.show', $hostel['id']) }}" class="text-decoration-none">
                        <div class="card card-profile-1 mb-4 h-100 hover-shadow"
                            style="cursor: pointer; transition: all 0.3s;">
                            <div class="card-body text-center">
                                <div class="avatar box-shadow-2 mb-3">
                                    @if ($hostel['logo'])
                                        <img src="{{ asset('storage/images/hostelLogos/' . $hostel['logo']) }}"
                                            alt="{{ $hostel['name'] }}"
                                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <img src="{{ asset('assets/images/logo.png') }}" alt="Default Logo"
                                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                    @endif
                                </div>
                                <h5 class="m-0 text-24">{{ $hostel['name'] }}</h5>
                                <p class="mt-0 mb-3 text-muted">{{ $hostel['block'] }}</p>

                                <div class="card-socials-simple mt-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <p class="text-primary mb-1"><i class="i-Calendar mr-1"></i> Check In</p>
                                            <span class="text-muted">
                                                {{ $hostel['check_in_date'] ? \Carbon\Carbon::parse($hostel['check_in_date'])->format('M d, Y') : 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <p class="text-primary mb-1"><i class="i-Calendar mr-1"></i> Check Out</p>
                                            <span class="text-muted">
                                                {{ $hostel['check_out_date'] ? \Carbon\Carbon::parse($hostel['check_out_date'])->format('M d, Y') : 'Ongoing' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    @if ($hostel['status'] == 'Current')
                                        <span class="badge badge-success px-3 py-2">Current Hostel</span>
                                    @else
                                        <span class="badge badge-secondary px-3 py-2">Past Hostel</span>
                                    @endif
                                </div>

                                <button class="btn btn-primary btn-rounded mt-3">
                                    <i class=""></i> View Details
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="i-Information text-muted" style="font-size: 48px;"></i>
                        <p class="text-muted mt-3">No hostel information available.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <style>
        .hover-shadow:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-5px);
        }

        .text-decoration-none {
            text-decoration: none !important;
        }

        .text-decoration-none:hover {
            text-decoration: none !important;
        }
    </style>
@endsection
