@extends('admin.layouts.hostelUserBackend')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-lg-12 col-md-12 mb-4">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <p class="text-muted mt-2 mb-0 mr-4">Welcome back</p>
                    <p class="text-primary text-34 line-height-1 mb-2">{{ $resident->full_name }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden">
                <div class="card-body text-center">
                    <i class="i-Home1 text-32 text-primary"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Hostels Lived</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $hostelsLived }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card card-icon-bg card-icon-bg-success o-hidden">
                <div class="card-body text-center">
                    <i class="i-Money-2 text-32 text-success"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Payments Done</p>
                        <p class="text-success text-24 line-height-1 mb-2">{{ $totalPayments }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
            <div class="card card-icon-bg card-icon-bg-warning o-hidden">
                <div class="card-body text-center">
                    <i class="i-Repeat-3 text-32 text-warning"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Bed Transfers</p>
                        <p class="text-warning text-24 line-height-1 mb-2">{{ $totalBedTransfers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Quick Actions</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('resident.hostels') }}" class="btn btn-primary btn-block btn-lg">
                                <i class="i-Home1 mr-2"></i> View All Hostels
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('resident.profile') }}" class="btn btn-info btn-block btn-lg">
                                <i class="i-User mr-2"></i> My Profile
                            </a>
                        </div>
                        {{-- <div class="col-md-4 mb-3">
                            <a href="#" class="btn btn-success btn-block btn-lg">
                                <i class="i-Receipt-4 mr-2"></i> My Payments
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
