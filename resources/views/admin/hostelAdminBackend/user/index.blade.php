@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Users of {{ $currentHostel->name }}</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.user.index') }}" class="text-primary">Index</a></li>
                <li>Users</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="clearfix mr-3">
                                <a href="{{ route('hostelAdmin.user.create') }}" class="btn btn-success">
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
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @php
                                                    $hostel = $user->hostels->first();
                                                    $roleId = $hostel?->pivot->role_id;
                                                    $role = \App\Models\Role::find($roleId);
                                                @endphp

                                                {{ $role->name }}
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    {{-- <a class="btn btn-warning mr-1"
                                                        href="{{ route('hostelAdmin.user.edit', $user->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a> --}}
                                                    <button class="btn btn-danger delete-user"
                                                        data-slug="{{ $user->slug }}">
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
            deleteAction('.delete-user', 'hostel/user');
            updatePublishStatus('.published', 'user/publish');
        });
    </script>
@endsection
