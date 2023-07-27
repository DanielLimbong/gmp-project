@extends('template')
@section('header')
    <h2>List User</h2>
@endsection

@section('content')
@if(session('success'))
    <!-- Success Toast -->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        })
    </script>
@endif

{{-- menu --}}
<div class="container-xxl">
    <div class="row">
        {{-- <div class="col text-left">Kolom 1</div>
        <div class="col text-center">Kolom 2</div> --}}
        <div class="col text-right pr-4">
            <div class="d-flex justify-content-end">
                <a class="btn btn-success ml-2" style="width: 150px;" href="{{ route('user.create') }}">
                    <i class="fas fa-plus"></i> Create
                </a>
                {{-- <button class="btn btn-secondary ml-2 buttons-excel buttons-html5" style="width: 150px;" tabindex="0" aria-controls="example1" type="button">Print</button>
                <button class="btn btn-info ml-2" style="width: 150px;">Button 3</button> --}}
            </div>
        </div>
    </div>
</div>

<br>

{{-- table --}}
<div class="row p-2">
    <div class="col-12 p-2">
        <div class="card p-2">
            <div class="card-header">
                {{-- <h2 class="">List User</h2> --}}
            </div>
            <div class="card-body table-responsive p-2">
                <table class="table table-hover text-nowrap" id="user_table">
                    <thead>
                        <tr>
                            <th class="align-middle">ID</th>
                            <th class="align-middle">NIK</th>
                            <th class="align-middle">Name</th>
                            <th class="align-middle">Email</th>
                            <th class="align-middle">Company</th>
                            <th class="align-middle">Position</th>
                            <th class="align-middle">Division</th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="align-middle">{{ $user->id }}</td>
                            <td class="align-middle">{{ $user->nik }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">{{ $user->company_code }}</td>
                            <td class="align-middle">{{ $user->position }}</td>
                            <td class="align-middle">{{ $user->division }}</td>
                            <td class="project-actions text-right">
															<div class="d-flex">
																	<!-- View Button -->
																	<button class="btn btn-primary view-user ml-4" data-toggle="modal" data-target="#viewUserModal" data-user="{{ $user }}">
																			<i class="fas fa-eye"></i> 
																	</button>
																	<!-- Edit Button -->
																	<a class="btn btn-info ml-4" href="{{ route('user.edit', $user) }}">
																			<i class="fas fa-pencil-alt"></i> 
																	</a>
																	<!-- Delete Button -->
																@if ($user->deletion_indicator === 'Yes')
																		<form action="{{ route('user.activate', $user) }}" method="POST">
																				@csrf
																				<button type="submit" class="btn btn-success  ml-4">
																						<i class="fas fa-check"></i> 
																				</button>
																		</form>
																@else
																		<form action="{{ route('user.delete', $user) }}" method="POST">
																				@csrf
																				<button type="submit" class="btn btn-danger btn ml-4">
																						<i class="fas fa-times"></i> 
																				</button>
																		</form>
																@endif
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

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">View User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="userId">ID:</label>
                    <input type="text" class="form-control" id="userId" readonly>
                </div>
                <div class="form-group">
                    <label for="userNik">NIK:</label>
                    <input type="text" class="form-control" id="userNik" readonly>
                </div>
                <div class="form-group">
                    <label for="userName">Name:</label>
                    <input type="text" class="form-control" id="userName" readonly>
                </div>
                <div class="form-group">
                    <label for="userEmail">Email:</label>
                    <input type="text" class="form-control" id="userEmail" readonly>
                </div>
                <div class="form-group">
                    <label for="userCompany">Company:</label>
                    <input type="text" class="form-control" id="userCompany" readonly>
                </div>
                <div class="form-group">
                    <label for="userPosition">Position:</label>
                    <input type="text" class="form-control" id="userPosition" readonly>
                </div>
                <div class="form-group">
                    <label for="userDivision">Division:</label>
                    <input type="text" class="form-control" id="userDivision" readonly>
                </div>
                <div class="form-group">
                    <label for="userDivision">Role:</label>
                    <input type="text" class="form-control" id="userRole" readonly>
                </div>
                <!-- Add more fields as needed to display user details -->
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
        $('.view-user').on('click', function() {
            var user = $(this).data('user');

            // Populate the modal with user details
            $('#userId').val(user.id);
            $('#userNik').val(user.nik);
            $('#userName').val(user.name);
            $('#userEmail').val(user.email);
            $('#userCompany').val(user.company_code);
            $('#userPosition').val(user.position);
            $('#userDivision').val(user.division);
            $('#userRole').val(user.role);

            // Show the modal
            $('#viewUserModal').modal('show');
        });

        // DataTables initialization
        $('#user_table').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>
@endsection
