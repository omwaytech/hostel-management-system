@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Property List</h1>
            <ul>
                <li><a href="{{ route('admin.hostel.index') }}" class="text-primary">Index</a></li>
                <li>Listed property</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-title">
                        <h5 class="card-title text-center mt-3">Property detail of hostel named
                            <strong>{{ $property->hostel_name }}</strong> by
                            <strong>{{ $property->owner_name }}</strong>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-2 text-end fw-bold"><strong>Hostel Name</strong></div>
                            <div class="col-1">:-</div>
                            <div class="col-7">{{ $property->hostel_name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 text-end fw-bold"><strong>Owner Name</strong></div>
                            <div class="col-1">:-</div>
                            <div class="col-7">{{ $property->owner_name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 text-end fw-bold"><strong>Hostel Email</strong></div>
                            <div class="col-1">:-</div>
                            <div class="col-7">{{ $property->hostel_email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 text-end fw-bold"><strong>Owner Contact</strong></div>
                            <div class="col-1">:-</div>
                            <div class="col-7">{{ $property->hostel_contact }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 text-end fw-bold"><strong>Address</strong></div>
                            <div class="col-1">:-</div>
                            <div class="col-7">{{ $property->hostel_location }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 text-end fw-bold"><strong>City</strong></div>
                            <div class="col-1">:-</div>
                            <div class="col-7">{{ $property->hostel_city }}</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.propertyList.approve', $property->slug) }}" method="POST"
                                class="approveForm">
                                @csrf
                                <button type="submit"
                                    class="btn {{ $property->is_approved ? 'btn-secondary' : 'btn-success' }} approveBtn"
                                    {{ $property->is_approved ? 'disabled' : '' }}>
                                    {{ $property->is_approved ? 'Approved' : 'Approve as Hostel' }}
                                </button>
                            </form>

                            {{-- <form action="{{ route('admin.propertyList.reject', $property->slug) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject the property</button>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script>
        $(document).ready(function() {
            $('.approveForm').on('submit', function() {
                var $btn = $(this).find('.approveBtn');
                $btn.prop('disabled', true);
                $btn.text('Approved');
                $btn.removeClass('btn-success').addClass('btn-secondary');
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $('.approveForm').on('submit', function(e) {
                e.preventDefault(); // Stop form from submitting immediately

                var form = this;
                var $btn = $(form).find('.approveBtn');

                // If already approved, block further action
                if ($btn.prop('disabled')) return;

                Swal.fire({
                    title: 'Approve this hostel?',
                    text: "Once approved, this property will become an active hostel.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    confirmButtonText: 'Approve',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#dc3545',
                    reverseButtons: false,
                    focusCancel: true,
                    customClass: {
                        confirmButton: 'order-1',
                        cancelButton: 'order-2'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Approving...',
                            text: 'Please wait while the hostel is being approved.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        form.submit();

                        $btn.prop('disabled', true)
                            .removeClass('btn-success')
                            .addClass('btn-secondary')
                            .text('Approved');
                    }
                });
            });
        });
    </script>
@endsection
