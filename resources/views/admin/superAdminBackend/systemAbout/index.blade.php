@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>About</h1>
            <ul>
                <li><a href="{{ route('admin.system-about.index') }}" class="text-primary">Index</a></li>
                <li>About</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            @if ($abouts->count() < 1)
                                <div class="clearfix mr-3">
                                    <a href="{{ route('admin.system-about.create') }}" class="btn btn-success">
                                        <i class="nav-icon fas fa-plus"></i> Add New
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Title</th>
                                        <th>Mission</th>
                                        <th>Vision</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abouts as $about)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $about->about_title }}</td>
                                            <td>{{ Str::words($about->about_mission, 10) }}</td>
                                            <td>{{ Str::words($about->about_vision, 10) }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-warning mr-1"
                                                        href="{{ route('admin.system-about.edit', $about->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger delete-about"
                                                        data-slug="{{ $about->slug }}">
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
            deleteAction('.delete-about', 'admin/system-about');
            updatePublishStatus('.published', 'system-about/publish');
        });
    </script>
@endsection
