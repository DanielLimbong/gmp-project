@extends('template')
@section('header')
    <h2>List User</h2>
@endsection
@section('content')
@if(session('success'))
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
        <a class="btn btn-success ml-2" style="width: 150px;" href="{{ route('user.create') }}"> <i class="fas fa-plus"></i>  Create</a>
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
					<th>ID</th>
					<th>NIK</th>
					<th>Name</th>
					<th>Email</th>
					<th>Company</th>
					<th>Position</th>
					<th>Division</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
          @foreach ($users as $user)
        <tr>

					<td>{{ $user->id }}</td>
					<td>{{ $user->nik }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->company_code }}</td>
					<td>{{ $user->position }}</td>
					<td>{{ $user->division }}</td>
					<td class="project-actions text-right">
						<a class="btn btn-primary btn-sm" href="{{ route('user.view', $user) }}">
							<i class="fas fa-eye">
							</i>
						View
						</a>
						<a class="btn btn-info btn-sm" href="#">
							<i class="fas fa-pencil-alt">
							</i>
							Edit
						</a>
							<a class="btn btn-danger btn-sm" href="#">
								<i class="fas fa-trash">
							</i>
							Delete
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
@section('js')
    <script>
        // let table = new DataTable('#user_table');
				$(document).ready(function() {
				$('#user_table').DataTable( {
						dom: 'Bfrtip',
						buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
						]
				} );
		} );
    </script>
		@endsection
@endsection