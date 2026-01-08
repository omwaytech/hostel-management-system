@extends('admin.layouts.hostelUserBackend')

@section('page-title', 'My Profile')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('resident.dashboard') }}">Dashboard</a>
    </li>
    <li>My Profile</li>
@endsection

@section('content')
    <div class="card user-profile o-hidden mb-4">
        <div class="user-info mt-4 mb-4">
            <img class="profile-picture avatar-lg mb-2"
                src="{{ $resident->photo ? asset('storage/images/residentPhotos/' . $resident->photo) : asset('assets/images/faces/1.jpg') }}"
                alt="Resident Photo" />
            <p class="m-0 text-24"><strong>{{ $resident->full_name }}</strong></p>
            <p class="text-muted">{{ Auth::user()->email }}</p>
        </div>

        <div class="tab-content" id="profileTabContent">
            <!-- Current Information -->
            <div class="tab-pane fade active show" id="about" role="tabpanel" aria-labelledby="about-tab">
                <div class="col-md-12 border-right pr-4">
                    <h4 class="mb-4 text-center"><strong>Personal Information</strong></h4>
                    <hr />
                    <div class="row ml-2">
                        <div class="col-md-4 col-12 mb-4">
                            <p class="text-primary mb-1"><i class="i-Phone text-16 mr-1"></i> Contact Number</p>
                            <span>{{ $resident->contact_number }}</span>
                        </div>
                        <div class="col-md-4 col-12 mb-4">
                            <p class="text-primary mb-1"><i class="i-Telephone text-16 mr-1"></i> Guardian Contact</p>
                            <span>{{ $resident->guardian_contact }}</span>
                        </div>
                        <div class="col-md-4 col-12 mb-4">
                            <p class="text-primary mb-1"><i class="i-Mail text-16 mr-1"></i> Email</p>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    <h4 class="mb-4 mt-4 text-center"><strong>Room Details</strong></h4>
                    <hr />
                    <div class="row ml-2">
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i> Block</p>
                            <span>{{ $resident->bed->room->floor->block->name ?? 'N/A' }} Block
                                {{ $resident->bed->room->floor->block->block_number ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-Building text-16 mr-1"></i> Floor</p>
                            <span>{{ $resident->bed->room->floor->floor_label ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-Door text-16 mr-1"></i> Room Number</p>
                            <span>{{ $resident->bed->room->room_number ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <p class="text-primary mb-1"><i class="i-Bed text-16 mr-1"></i> Bed Number</p>
                            <span>{{ $resident->bed->bed_number ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <h4 class="mb-4 mt-4 text-center"><strong>Stay Information</strong></h4>
                    <hr />
                    <div class="row ml-2">
                        <div class="col-md-4 col-12 mb-4">
                            <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i> Check In Date</p>
                            <span>{{ \Carbon\Carbon::parse($resident->check_in_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="col-md-4 col-12 mb-4">
                            <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i> Check Out Date</p>
                            <span>{{ $resident->check_out_date ? \Carbon\Carbon::parse($resident->check_out_date)->format('M d, Y') : 'Ongoing' }}</span>
                        </div>
                        <div class="col-md-4 col-12 mb-4">
                            <p class="text-primary mb-1"><i class="i-Clock text-16 mr-1"></i> Occupancy Type</p>
                            <span>{{ $resident->occupancy->occupancy_type ?? 'N/A' }}</span>
                        </div>
                    </div>

                    @if ($resident->citizenship)
                        <h4 class="mb-4 mt-4 text-center"><strong>Identification Document</strong></h4>
                        <hr />
                        <div class="row ml-2">
                            <div class="col-md-12 mb-4 text-center">
                                <img src="{{ asset('storage/images/residentCitizenship/' . $resident->citizenship) }}"
                                    alt="ID Document" class="img-thumbnail"
                                    style="max-width: 300px; cursor: pointer; border-radius: 10px;"
                                    onclick="window.open(this.src, '_blank')">
                                <p class="text-muted mt-2">Click image to view full size</p>
                            </div>
                        </div>
                    @endif

                    <div class="text-center mt-4 mb-4">
                        <a href="{{ route('resident.hostels') }}" class="btn btn-primary">
                            <i class="i-Home1 mr-1"></i> View All Hostels & Payment History
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
