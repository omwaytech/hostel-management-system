@php
    // Determine layout based on user role
    $user = auth()->user();
    $layout = 'admin.layouts.hostelAdminBackend'; // Default

    if ($user->role_id == 1) {
        // Super Admin
        $layout = 'admin.layouts.superAdminBackend';
    } elseif ($user->role_id == 2) {
        // Hostel Admin
        $layout = 'admin.layouts.hostelAdminBackend';
    } elseif ($user->role_id == 3) {
        // Hostel Warden
        $layout = 'admin.layouts.hostelUserBackend';
    }
@endphp

@extends($layout)

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Notifications</h1>
            <ul>
                <li><a href="{{ route('notification.index') }}" class="text-danger">Index</a></li>
                <li>All Notifications</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">

                    <div class="card-body">
                        @if ($notifications->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-bell-slash text-muted" style="font-size: 48px;"></i>
                                <p class="text-muted mt-3">No notifications found</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">S.N.</th>
                                            <th style="width: 200px;">Title</th>
                                            <th>Message</th>
                                            <th style="width: 120px;">Type</th>
                                            {{-- <th style="width: 100px;">Status</th> --}}
                                            <th style="width: 150px;">Created</th>
                                            <th style="width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $notify)
                                            <tr class="{{ $notify->read_at ? '' : 'table-warning' }}"
                                                id="notification-{{ $notify->id }}">
                                                <td>{{ ($notifications->currentPage() - 1) * $notifications->perPage() + $loop->iteration }}
                                                </td>
                                                <td class="{{ $notify->read_at ? '' : 'fw-bold' }}">
                                                    {{ $notify->data['title'] ?? 'Notification' }}
                                                </td>
                                                <td class="{{ $notify->read_at ? '' : 'fw-bold' }}">
                                                    {{ $notify->data['message'] ?? 'No message' }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-white">
                                                        {{ $notify->data['type'] ?? 'General' }}
                                                    </span>
                                                </td>
                                                {{-- <td>
                                                    {!! $notify->read_at
                                                        ? '<span class="badge bg-success"> Read</span>'
                                                        : '<span class="badge bg-warning"> Unread</span>' !!}
                                                </td> --}}
                                                <td>
                                                    <small title="{{ $notify->created_at->format('Y-m-d H:i:s') }}">
                                                        {{ $notify->created_at->diffForHumans() }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @if ($notify->data['link'] ?? false)
                                                            <a href="{{ $notify->data['link'] }}"
                                                                class="btn btn-primary mark-as-read-link"
                                                                data-id="{{ $notify->id }}" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        @endif
                                                        {{-- @if (!$notify->read_at)
                                                            <button class="btn btn-success mark-as-read"
                                                                data-id="{{ $notify->id }}" title="Mark as read">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @endif --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
