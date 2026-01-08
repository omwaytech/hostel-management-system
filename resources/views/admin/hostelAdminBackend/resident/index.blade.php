@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Residents</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.resident.index') }}" class="text-primary">Index</a></li>
                <li>Residents</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="clearfix mr-3">
                                <a href="{{ route('hostelAdmin.resident.create') }}" class="btn btn-success">
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
                                        <th>Resident Name</th>
                                        <th>Block</th>
                                        <th>Floor</th>
                                        <th>Room Number</th>
                                        <th>Bed Number</th>
                                        <th>Room Type</th>
                                        {{-- <th>Publish ?</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residents as $resident)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $resident->full_name }}</td>
                                            <td>{{ $resident->bed->room->floor->block->name }}</td>
                                            <td>{{ $resident->bed->room->floor->floor_label }}</td>
                                            <td>{{ $resident->bed->room->room_number }}</td>
                                            <td>{{ $resident->bed->bed_number }}</td>
                                            <td>{{ $resident->occupancy->occupancy_type ?? '' }}</td>
                                            {{-- <td>
                                                <select class="form-control published" name="is_published"
                                                    data-model="is_published" data-slug="{{ $resident->slug }}"
                                                    id="published-{{ $resident->slug }}">
                                                    <option value="" disabled selected>Select one</option>
                                                    <option value="0"
                                                        {{ old('is_published', $resident->is_published) == '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                    <option value="1"
                                                        {{ old('is_published', $resident->is_published) == '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                </select>
                                            </td> --}}
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-info mr-1"
                                                        href="{{ route('hostelAdmin.resident.show', $resident->slug) }}">
                                                        <i class="nav-icon fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-warning mr-1"
                                                        href="{{ route('hostelAdmin.resident.edit', $resident->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger delete-room"
                                                        data-slug="{{ $resident->slug }}">
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
            deleteAction('.delete-room', 'hostel/room');
            updatePublishStatus('.published', 'room/publish');
        });
    </script>
@endsection
