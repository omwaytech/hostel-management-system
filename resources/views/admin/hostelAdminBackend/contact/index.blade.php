@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Contact</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.contact-us.index') }}" class="text-primary">Index</a></li>
                <li>Contact</li>
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
                                        <th>S.N</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                            <td>{{ $contact->email_address }}</td>
                                            <td>{{ $contact->phone_number }}</td>
                                            <td>{{ $contact->message }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-danger delete-contact"
                                                        data-slug="{{ $contact->slug }}">
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
            deleteAction('.delete-contact', 'hostel/contact-us');
        });
    </script>
@endsection
