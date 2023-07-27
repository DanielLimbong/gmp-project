@extends('template')
@section('header')
    <h2>List Company</h2>
@endsection

@section('content')
@if(session('success'))
    <!-- Success Toast -->
    <script>
        // ... Toast code ...
    </script>
@endif

<!-- Create Button -->
<div class="container-xxl">
    <div class="row">
        <div class="col text-right">
            <div class="d-flex justify-content-end pr-2">
                <a href="{{ route('company.create') }}" class="btn btn-success ml-2" style="width: 150px;">
                    <i class="fas fa-plus"></i> Create
                </a>
            </div>
        </div>
    </div>
</div>

<br>

<!-- Company Table -->
<div class="row">
    <div class="col-12">
        <div class="card p-5">
            <div class="card-header"></div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="company_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Company Code</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($companies as $company)
                        <tr>
                            <td class="align-middle">{{ $company->id }}</td>
                            <td class="align-middle">{{ $company->name }}</td>
                            <td class="align-middle">{{ $company->company_code }}</td>
                            <td class="project-actions text-right">
                                <!-- View Button -->
                                <button class="btn btn-primary ml-4 view-company" data-toggle="modal" data-target="#viewCompanyModal" data-name="{{ $company->name }}" data-code="{{ $company->company_code }}">
                                    <i class="fas fa-eye"></i> 
                                </button>
                                <!-- Edit Button -->
                                <a class="btn btn-info ml-4" href="{{ route('company.edit', $company) }}">
                                    <i class="fas fa-pencil-alt"></i> 
                                </a>
                                <!-- Delete Button -->
                                <a class="btn btn-danger ml-4" href="#">
                                    <i class="fas fa-times"></i> 
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- View Company Modal -->
<div class="modal fade" id="viewCompanyModal" tabindex="-1" role="dialog" aria-labelledby="viewCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCompanyModalLabel">View Company Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="companyName">Company Name:</label>
                    <input type="text" class="form-control" id="companyName" readonly>
                </div>
                <div class="form-group">
                    <label for="companyCode">Company Code:</label>
                    <input type="text" class="form-control" id="companyCode" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    // JavaScript to handle view button click event
    $(document).ready(function() {
        $('.view-company').on('click', function() {
            var companyName = $(this).data('name');
            var companyCode = $(this).data('code');

            // Populate the modal with company details
            $('#companyName').val(companyName);
            $('#companyCode').val(companyCode);

            // Show the modal
            $('#viewCompanyModal').modal('show');
        });

        // DataTables initialization
        $('#company_table').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>
@endsection
