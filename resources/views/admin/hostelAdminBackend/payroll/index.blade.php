@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Payroll</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.payroll.index') }}" class="text-primary">Index</a></li>
                <li>Payroll</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-start mb-3">
                            <div class="clearfix ml-3">
                                <button class="btn btn-success" data-toggle="modal" data-target="#searchStaffModal">
                                    <i class="nav-icon fas fa-search"></i> Search Staff
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="zero_configuration_table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Invoice Number</th>
                                        <th>Block</th>
                                        {{-- <th>Publish ?</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payrolls as $payroll)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $payroll->staff->full_name }}</td>
                                            <td>{{ $payroll->invoice_number }}</td>
                                            {{-- <td>
                                                <select class="form-control published" name="is_published"
                                                    data-model="is_published" data-slug="{{ $payroll->slug }}"
                                                    id="published-{{ $payroll->slug }}">
                                                    <option value="" disabled selected>Select one</option>
                                                    <option value="0"
                                                        {{ old('is_published', $payroll->is_published) == '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                    <option value="1"
                                                        {{ old('is_published', $payroll->is_published) == '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                </select>
                                            </td> --}}
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-info mr-1"
                                                        href="{{ route('hostelAdmin.payroll.show', $payroll->slug) }}">
                                                        <i class="nav-icon fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-warning mr-1"
                                                        href="{{ route('hostelAdmin.payroll.edit', $payroll->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger delete-payroll"
                                                        data-slug="{{ $payroll->slug }}">
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
    <!-- Modal -->
    <div class="modal fade" id="searchStaffModal" tabindex="-1" role="dialog" aria-labelledby="searchStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Search input -->
                    <input type="text" autofocus id="staffSearchInput" class="form-control mb-3"
                        placeholder="Search by name, contact">

                    <!-- Results -->
                    <div id="staffSearchResults" class="list-group">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#searchStaffModal').on('shown.bs.modal', function() {
            $('#staffSearchInput').trigger('focus');
        });
        $(document).ready(function() {
            deleteAction('.delete-payroll', 'hostel/payroll');

            $('#staffSearchInput').on('keyup', function() {
                let keyword = $(this).val();

                if (keyword.length < 2) {
                    $('#staffSearchResults').html('');
                    return;
                }

                $.ajax({
                    url: "{{ route('hostelAdmin.staff.search') }}",
                    type: 'GET',
                    data: {
                        keyword: keyword
                    },
                    success: function(staffs) {
                        let resultsHtml = '';
                        if (staffs.length === 0) {
                            resultsHtml = '<p class="text-muted">No staffs found.</p>';
                        } else {
                            staffs.forEach(function(staff) {
                                resultsHtml += `
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="/hostel/payroll/${staff.slug}/create">
                                            <div>
                                                <strong>${staff.full_name}</strong><br>
                                                <small>${staff.contact} | Block: ${staff.block_name}</small>
                                            </div>
                                        </a>
                                    </div>
                                `;
                            });
                        }
                        $('#staffSearchResults').html(resultsHtml);
                    }
                });
            });
        });
    </script>
@endsection
