@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Notifications</h1>
            <ul>
                <li><a href="{{ route('notification.index') }}" class="text-primary">Index</a></li>
                <li>Notifications</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notify)
                                        <tr class="{{ $notify->read_at ? '' : 'fw-bold' }}">
                                            <td>{{ $notify->data['title'] ?? '' }}</td>
                                            <td>{{ $notify->data['message'] ?? '' }}</td>
                                            <td>{{ $notify->data['type'] ?? '' }}</td>
                                            <td>
                                                {!! $notify->read_at
                                                    ? '<span class="badge bg-success">Seen</span>'
                                                    : '<span class="badge bg-warning">Unseen</span>' !!}
                                            </td>
                                            <td>{{ $notify->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('notification.show', $notify->id) }}"
                                                    class="btn btn-sm btn-primary">View</a>
                                                <form action="{{ route('notification.destroy', $notify->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this notification?')">Delete</button>
                                                </form>
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
            deleteAction('.delete-occupancy', 'hostel/occupancy');
            updatePublishStatus('.published', 'occupancy/publish');
        });
    </script>
@endsection
