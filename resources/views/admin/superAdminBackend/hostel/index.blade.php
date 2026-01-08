@extends('admin.layouts.superAdminBackend')

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Hostels</h1>
            <ul>
                <li><a href="{{ route('admin.hostel.index') }}" class="text-primary">Index</a></li>
                <li>Hostels</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>

        {{-- Import Results --}}
        @if (session('import_success') !== null)
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-{{ session('import_errors', 0) > 0 ? 'warning' : 'success' }} alert-dismissible fade show"
                        role="alert">
                        <strong>Import Summary:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Successfully imported: <strong>{{ session('import_success') }}</strong> hostel(s)</li>
                            @if (session('import_errors', 0) > 0)
                                <li>Failed: <strong>{{ session('import_errors') }}</strong> record(s)</li>
                            @endif
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Display errors if 5 or fewer --}}
        @if (session('import_error_details'))
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Import Errors Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger">
                                <strong>The following errors occurred during import:</strong>
                                <ul class="mt-2 mb-0">
                                    @foreach (session('import_error_details') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <p class="mb-0 text-muted">
                                <small><i class="fas fa-info-circle"></i> Please fix these errors in your Excel file and try
                                    importing again.</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="fas fa-file-import"></i> Import Excel
                                </button>
                                <a href="{{ route('admin.hostel.download-template') }}" class="btn btn-info">
                                    <i class="fas fa-download"></i> Download Template
                                </a>
                            </div>
                            <div class="clearfix">
                                <a href="{{ route('admin.hostel.create') }}" class="btn btn-success">
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
                                        <th>Hostel Name</th>
                                        {{-- <th>Publish ?</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hostels as $hostel)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $hostel->name }}</td>
                                            {{-- <td>
                                                <select class="form-control published" name="is_published"
                                                    data-model="is_published" data-slug="{{ $hostel->slug }}"
                                                    id="published-{{ $hostel->slug }}">
                                                    <option value="" disabled selected>Select one</option>
                                                    <option value="0"
                                                        {{ old('is_published', $hostel->is_published) == '0' ? 'selected' : '' }}>
                                                        No
                                                    </option>
                                                    <option value="1"
                                                        {{ old('is_published', $hostel->is_published) == '1' ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
                                                </select>
                                            </td> --}}
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-info mr-1"
                                                        href="{{ route('admin.hostel.dashboard', $hostel->token) }}">
                                                        <i class="fas fa-eye"></i> Open Dashboard
                                                    </a>
                                                    <a class="btn btn-warning mr-1"
                                                        href="{{ route('admin.hostel.edit', $hostel->slug) }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger delete-hostel"
                                                        data-slug="{{ $hostel->slug }}">
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

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.hostel.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Hostels from Excel</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="excel_file">
                                <h6>Select Excel File <code>*</code></h6>
                            </label>
                            <input type="file" name="excel_file" id="excel_file" class="form-control"
                                accept=".xlsx,.xls,.csv" required>
                            <small class="form-text text-muted">
                                Supported formats: .xlsx, .xls, .csv<br>
                                Please download the template first to ensure correct format.
                            </small>
                        </div>
                        <div class="alert alert-info">
                            <strong>Note:</strong>
                            <ul class="mb-0">
                                <li>Required fields: Name, Contact, Location, Email, Type, Description</li>
                                <li>Type must be: Boys, Girls, or Co-ed</li>
                                <li>Email must be unique</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            deleteAction('.delete-hostel', 'admin/hostel');
            updatePublishStatus('.published', 'hostel/publish');
        });
    </script>
@endsection
