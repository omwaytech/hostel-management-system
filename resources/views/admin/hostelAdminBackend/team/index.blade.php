@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Team</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.team.index') }}" class="text-primary">Index</a></li>
                <li>Team</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="clearfix mr-3">
                                <a href="{{ route('hostelAdmin.team.create') }}" class="btn btn-success">
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
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Publish ?</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teams as $team)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $team->member_name }}</td>
                                            <td>{{ $team->member_designation }}</td>
                                            <td>
                                                <select class="form-control published" name="is_published"
                                                    data-model="is_published" data-slug="{{ $team->slug }}"
                                                    id="published-{{ $team->slug }}">
                                                    <option value="" disabled selected>Select one</option>
                                                    <option value="0"
                                                        {{ old('is_published', $team->is_published ?? 0) == '0' ? 'selected' : '' }}>
                                                        No</option>
                                                    <option value="1"
                                                        {{ old('is_published', $team->is_published ?? 1) == '1' ? 'selected' : '' }}>
                                                        Yes</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-warning mr-1"
                                                        href="{{ route('hostelAdmin.team.edit', $team->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger delete-team"
                                                        data-slug="{{ $team->slug }}">
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
            deleteAction('.delete-team', 'hostel/team');
            updatePublishStatus('.published', 'team/publish');
        });
    </script>
@endsection
