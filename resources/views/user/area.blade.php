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
                    <th class="text-center">Action</th>
				</tr>
				</thead>
				<tbody>
          @foreach ($areas as $area)
        <tr>

					<td class="align-middle">{{ $area->id }}</td>
					<td class="align-middle">{{ $area->area_name }}</td>
                    <td class="align-middle">{{ $area->created_at }}</td>
<td class="align-middle">
    @if ($area->deletion_indicator === 'No')
        Active
    @elseif ($area->deletion_indicator === 'Yes')
        Deactived
    @else
        <!-- Tampilkan pesan jika nilai deletion_indicator tidak sama dengan 'No' atau 'Yes' -->
        Unknown
    @endif
</td>
					<td class="project-actions text-right">
                         <div class="d-flex">
							<button class="btn btn-primary  view-area ml-4" data-toggle="modal" data-target="#viewAreaModal" data-area="{{ $area }}">
									<i class="fas fa-eye"></i> 
							</button>
							<a class="btn btn-info ml-4" href="{{ route('area.edit', $area) }}">
									<i class="fas fa-pencil-alt"></i> 
							</a>
							{{-- <a class="btn btn-danger ml-4" href="#">

									<i class="fas fa-times-circle"></i> 
							</a> --}}
                                                                    @if ($area->deletion_indicator === 'Yes')
																		<form action="{{ route('area.activate', $area) }}" method="POST">
																				@csrf
																				<button type="submit" class="btn btn-success  ml-4">
																						<i class="fas fa-check-square"></i> 
																				</button>
																		</form>
																@else
																		<form action="{{ route('area.delete', $area) }}" method="POST">
																				@csrf
																				<button type="submit" class="btn btn-danger btn ml-4">
																						<i class="fas fa-times-circle"></i> 
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
  <div class="modal fade" id="viewAreaModal" tabindex="-1" role="dialog" aria-labelledby="viewAreaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAreaModalLabel">View Area Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="areaId">ID:</label>
                        <input type="text" class="form-control" id="areaId" readonly>
                    </div>
                    <div class="form-group">
                        <label for="areaName">Area Name:</label>
                        <input type="text" class="form-control" id="areaName" readonly>
                    </div>
                    <div class="form-group">
                        <label for="areaCreated">Created:</label>
                        <input type="text" class="form-control" id="areaCreated" readonly>
                    </div>
                    <div class="form-group">
                        <label for="areaStatus">Status:</label>
                        <input type="text" class="form-control" id="areaStatus" readonly>
                    </div>
                    <!-- Add more fields as needed to display area details -->
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
        $(document).ready(function() {
            $('#area_table').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            $('.view-area').on('click', function() {
                var area = $(this).data('area');

                // Populate the modal with area details
                $('#areaId').val(area.id);
                $('#areaName').val(area.area_name);
                $('#areaCreated').val(area.created_at);
                $('#areaStatus').val(area.deletion_indicator);

                // Show the modal
                $('#viewAreaModal').modal('show');
            });
        });
    </script>
@endsection


