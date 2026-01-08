@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="breadcrumb">
        <h1>Staff Profile</h1>
        <ul>
            <li><a href="{{ route('hostelAdmin.staff.index') }}">Index</a></li>
            <li>Staff Profile</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card user-profile o-hidden mb-4">
        <div class="header-cover"
            style="background-image: url('{{ asset('storage/images/hostelLogos/' . $staff->block->hostel->logo) }}')">
        </div>
        <div class="user-info">
            <img class="profile-picture avatar-lg mb-2" src="{{ asset('storage/images/staffPhotos/' . $staff->photo) }}"
                alt="Resident Photo" />
            <p class="m-0 text-24"><strong>{{ $staff->full_name }}</strong></p>
        </div>
        <hr />
        <div class="col-md-12 border-right pr-4">
            <h4 class="mb-4 text-center"><strong>Staff Information</strong></h4>
            <hr />
            <div class="row ml-2">
                <div class="col-md-3 col-6 mb-4">
                    <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i> Contact Number</p>
                    <span>{{ $staff->contact_number }}</span>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <p class="text-primary mb-1"><i class="i-Face-Style-4 text-16 mr-1"></i> Check In Date</p>
                    <span>{{ $staff->join_date }}</span>

                    <p class="text-primary mb-1 mt-3"><i class="i-Face-Style-4 text-16 mr-1"></i> Check Out Date</p>
                    <span>{{ $staff->leave_date ?? 'N/A' }}</span>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> ID</p>
                    <span>
                        <img src="{{ asset('storage/images/staffCitizenship/' . $staff->citizenship) }}" alt="ID"
                            class="img-thumbnail" style="max-width: 120px; cursor: pointer; border-radius: 20px;"
                            data-toggle="modal" data-target="#citizenshipModal">
                    </span>
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
                    <img src="{{ asset('storage/images/staffCitizenship/' . $staff->citizenship) }}" alt="Full ID Image"
                        class="img-fluid mb-3">

                    <div class="mt-3">
                        <a href="{{ asset('storage/images/staffCitizenship/' . $staff->citizenship) }}"
                            class="btn btn-primary" download>
                            Download
                        </a>
                        <button type="button" class="btn btn-secondary ml-2" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
