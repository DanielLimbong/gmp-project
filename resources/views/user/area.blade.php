@extends('template')
@section('header')
    <h2>List Area</h2>
@endsection
@section('content')
@if(session('success'))
    <script>
        Swal.(fire(
            'Good job!',
            '{{ session('success') }}',
            'success'
        );)
    </script>
@endif
{{-- Header --}}
<div class="container-xxl">
  <div class="row">
    {{-- <div class="col text-left">Kolom 1</div>
    <div class="col text-center">Kolom 2</div> --}}
    <div class="col text-right">
			<div class="d-flex justify-content-end">
                <a href="{{ route('area.create') }}" class="btn btn-success ml-2" style="width: 150px;"><i class="fas fa-plus"></i> Create</a>
                {{-- <a href="#" class="btn btn-primary ml-2" style="width: 150px;"><i class="fas fa-edit"></i> Preview</a>
                <a href="#" class="btn btn-info ml-2" style="width: 150px;"><i class="fas fa-list-ol"></i> Numbering</a> --}}
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
			<div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap" id="area_table">
				<thead>
				<tr>
					<th>ID</th>
					<th>Area Name</th>
          <th>Created</th>
					<th>Status</th>
          <th></th>
				</tr>
				</thead>
				<tbody>
          @foreach ($areas as $area)
        <tr>

					<td>{{ $area->id }}</td>
					<td>{{ $area->area_name }}</td>
          <td>{{ $area->created_at }}</td>
					<td>{{ $area->deletion_indicator }}</td>
					<td class="project-actions text-right">
						<a class="btn btn-primary btn-sm" href="#">
							<i class="fas fa-eye">
							</i>
						View
						</a>
						<a class="btn btn-info btn-sm" href="{{ route('area.edit', $area) }}">
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
				$(document).ready(function() {
				$('#area_table').DataTable( {
						dom: 'Bfrtip',
						buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
						]
				} );
		} );
      </script>
		@endsection
@endsection

