@extends('admin.layouts.hostelAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Resident Bill</h1>
            <ul>
                <li><a href="{{ route('hostelAdmin.bill.index') }}" class="text-primary">Index</a></li>
                <li>Resident Bill</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-start mb-3">
                            <div class="clearfix ml-3">
                                <button class="btn btn-success" data-toggle="modal" data-target="#searchResidentModal">
                                    <i class="nav-icon fas fa-search"></i> Search Resident
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
                                        <th>Resident Name</th>
                                        <th>Month</th>
                                        <th>Generated On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bills as $bill)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $bill->invoice_number }}</td>
                                            <td>{{ $bill->resident->full_name }}</td>
                                            <td>{{ $bill->month }}</td>
                                            <td>{{ $bill->created_at->format('d M Y') }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-info mr-1"
                                                        href="{{ route('hostelAdmin.bill.show', $bill->slug) }}">
                                                        <i class="nav-icon fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-danger delete-bill"
                                                        data-slug="{{ $bill->slug }}">
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
    <div class="modal fade" id="searchResidentModal" tabindex="-1" role="dialog"
        aria-labelledby="searchResidentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search Resident</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Search input -->
                    <input type="text" autofocus id="residentSearchInput" class="form-control mb-3"
                        placeholder="Search by name, contact, block, floor, room, bed">

                    <!-- Results -->
                    <div id="residentSearchResults" class="list-group">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#searchResidentModal').on('shown.bs.modal', function() {
            $('#residentSearchInput').trigger('focus');
        });
        $(document).ready(function() {
            deleteAction('.delete-bill', 'hostel/bill');

            $('#residentSearchInput').on('keyup', function() {
                let keyword = $(this).val();

                if (keyword.length < 2) {
                    $('#residentSearchResults').html('');
                    return;
                }

                $.ajax({
                    url: "{{ route('hostelAdmin.resident.search') }}",
                    type: 'GET',
                    data: {
                        keyword: keyword
                    },
                    success: function(residents) {
                        let resultsHtml = '';
                        if (residents.length === 0) {
                            resultsHtml = '<p class="text-muted">No residents found.</p>';
                        } else {
                            residents.forEach(function(resident) {
                                resultsHtml += `
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="/hostel/bill/${resident.slug}/create">
                                            <div>
                                                <strong>${resident.full_name}</strong><br>
                                                <small>${resident.contact} | Block: ${resident.block_name}, Floor: ${resident.floor_label}, Room: ${resident.room_number}, Bed: ${resident.bed_number}</small>
                                            </div>
                                        </a>
                                    </div>
                                `;
                            });
                        }
                        $('#residentSearchResults').html(resultsHtml);
                    }
                });
            });
        });
    </script>
@endsection
