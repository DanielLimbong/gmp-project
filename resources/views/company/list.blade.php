@extends('template')
@section('header')
    <h2>List Company</h2>
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
      <div class="col text-right">
        <div class="d-flex justify-content-end pr-2">
          <a href="{{ route('company.create') }}" class="btn btn-success ml-2" style="width: 150px;"> <i class="fas fa-plus"></i> Create</a>
          {{-- <button class="btn btn-secondary ml-2 buttons-excel buttons-html5" style="width: 150px;" tabindex="0" aria-controls="example1" type="button">Print</button>
          <button class="btn btn-info ml-2" style="width: 150px;">Button 3</button> --}}
        </div>
      </div>
    </div>
  </div>


  <br>

  {{-- table --}}
  <div class="row">
    <div class="col-12">
      <div class="card p-5">
        <div class="card-header">
          {{-- <h2 class="">List User</h2> --}}
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap" id="company_table">
          <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Company Code</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
            @foreach ($companies as $company)
          <tr>

            <td>{{ $company->id }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->company_code }}</td>
            <td class="project-actions text-right">
              <a class="btn btn-primary btn-sm" href="#">
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
				$(document).ready(function() {
				$('#company_table').DataTable( {
						dom: 'Bfrtip',
						buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
						]
				} );
		} );
      </script>
      @endsection
@endsection