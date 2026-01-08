@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <a href="{{ route('admin.property-list.index') }}">
                    <div class="card-body text-center"><i class="i-Home1"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">Property List</p>
                        </div>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $totalProperties->count() }}</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <a href="{{ route('admin.hostel.index') }}">
                    <div class="card-body text-center"><i class="i-Home1"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">Hostels</p>
                            <p class="text-primary text-24 line-height-1 mb-2">{{ $totalHostels->count() }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Home1"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Blocks</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $totalBlocks->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Business-ManWoman"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Residents</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $totalResidents->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Administrator"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Staffs</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $totalStaffs->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
