@extends('template')
@section('header')
    <h1>List Question</h1>
@endsection
@section('content')
@if(session('success'))
    <script>
    Swal.fire({
     title: "Success!!",
     text: "{{ session('success') }}",
     type: "success",
     timer: 3000
     });
    </script>
@endif
{{-- Header --}}
<div class="container-xxl">
  <div class="row">
    {{-- <div class="col text-left">Kolom 1</div>
    <div class="col text-center">Kolom 2</div> --}}
    <div class="col text-right">
			<div class="d-flex justify-content-end">
                <a href="{{ route('question.create') }}" class="btn btn-success ml-2" style="width: 150px;"><i class="fas fa-plus"> </i> Create</a>
                <a href="{{ route('question.preview', $area) }}" class="btn btn-primary ml-2" style="width: 150px;"><i class="fas fa-edit"></i>Preview</a>
                <a href="{{ route('question.numbering', $area) }}" class="btn btn-info ml-2" style="width: 150px;"><i class="fas fa-list-ol"></i> Numbering</a>
      </div>
		</div>
  </div>
</div>

<br>
{{-- table --}}
    <div class="row p-2">
        <div class="col-12 p-2">
            <div class="card p-2">

                <!-- /.card-header -->
                <div class="card-body table-responsive p-2">
                    <table class="table table-hover text-nowrap" id="question_table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Weight</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Numbering</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->question }}</td>
                                    <td>{{ $row->weight }}</td>
                                    <td>{{ $row->areas->area_name }}</td>
                                    <td>                                            
                                        @if ($row->status == 'active')
                                            Active
                                        @else
                                            Non-Active
                                        @endif
                                    </td>
                                    <td>{{ $row->numbering }}</td>
                                    <td>
                                        <form action="{{ route('question.update', ['question' => $row->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            @if ($row->status == 'active')
                                                <button type="submit" class="btn btn-block btn-danger">Deactivate</button>
                                            @else
                                                <button type="submit" class="btn btn-block btn-success">Activate</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>



                </div>

                <!-- /.card-body -->

            </div>

            <!-- /.card -->

        </div>

    </div>
    @section('js')
    <script>
        // let table = new DataTable('#');
                // let table = new DataTable('#user_table');
				$(document).ready(function() {
				$('#question_table').DataTable( {
						dom: 'Bfrtip',
						buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
						]
				} );
		} );
    </script>
		@endsection
@endsection
