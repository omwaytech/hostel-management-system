@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Staffs</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.staff.index') }}" class="text-primary">Index</a></li>
                <li>Staffs</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="clearfix mr-3">
                                <a href="{{ route('hostelAdmin.staff.create') }}" class="btn btn-success">
                                    <i class="nav-icon fas fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Block</th>
                                        <th>Staff Name</th>
                                        {{-- <th>Publish ?</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($staffs as $staff)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $staff->block->name }}</td>
                                            <td>{{ $staff->full_name }}</td>
                                            {{-- <td>
                                                <select class="form-control published" name="is_published"
                                                    data-model="is_published" data-slug="{{ $staff->slug }}"
                                                    id="published-{{ $staff->slug }}">
                                                    <option value="" disabled selected>Select one</option>
                                                    <option value="0"
                                                        {{ old('is_published', $staff->is_published) == '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                    <option value="1"
                                                        {{ old('is_published', $staff->is_published) == '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                </select>
                                            </td> --}}
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-info mr-1"
                                                        href="{{ route('hostelAdmin.staff.show', $staff->slug) }}">
                                                        <i class="nav-icon fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-warning mr-1"
                                                        href="{{ route('hostelAdmin.staff.edit', $staff->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger delete-staff"
                                                        data-slug="{{ $staff->slug }}">
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            deleteAction('.delete-staff', 'hostel/staff');
            updatePublishStatus('.published', 'staff/publish');
        });
    </script>
@endsection
