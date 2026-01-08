<div class="dropdown me-3 mt-2 ml-4">
    <a href="#" class="nav-link position-relative" id="notificationDropdown" data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="i-Bell1 me-1" style="font-size: 18px;"></i>
        @if ($unreadCount > 0)
            <span class="badge bg-success position-absolute top-0 start-100 translate-middle">
                {{ $unreadCount }}
            </span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown"
        style="width: 380px; border-radius: 10px;">

        <li class="dropdown-header fw-bold fs-6 px-3 py-2" style="font-size: 18px;">Notifications</li>
        <div class="notification-scroll" style="max-height: 400px; overflow-y: auto;">
            @forelse($notifications as $notify)
                <li class="notification-item {{ $notify->read_at ? '' : 'unread-notification' }}"
                    data-id="{{ $notify->id }}">
                    <a href="{{ $notify->data['link'] ?? '#' }}"
                        class="dropdown-item notification-link d-flex align-items-start py-2 px-3">
                        <i class="far fa-comment-alt text-primary mt-3 me-3 mr-3 flex-shrink-0"
                            style="font-size: 18px;"></i>
                        <div class="notification-text flex-grow-1">
                            <div class="fw-semibold">
                                {{ $notify->data['title'] }}
                            </div>
                            <div class="notification-message">
                                {{ $notify->data['message'] }}
                            </div>
                            <small class="text-muted">
                                {{ $notify->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </a>
                </li>
                <hr class="dropdown-divider m-0">
            @empty
                <li class="dropdown-item text-center text-muted">No notifications</li>
            @endforelse
        </div>

        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a href="{{ route('notification.index') }}" class="dropdown-item text-center">
                View all
            </a>
        </li>
    </ul>
</div>
