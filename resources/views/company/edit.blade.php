@extends('template')
@section('header')
    <h2>Edit Company</h2>
@endsection
@section('content')
<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Edit Company</h3>
	</div>
	<form action="{{ route('company.put', $company) }}" method="POST">
    @csrf
		<div class="card-body">
			<div class="form-group">
				<label for="exampleInputEmail1">Company Name</label>
				<input type="text" class="form-control" id="exampleInputEmail1" placeholder="{{ old('name', $company->name) }}" name="name"></div>

			<div class="form-group">
				<label for="exampleInputEmail1">Company Code</label>
				<input type="text" class="form-control" id="exampleInputEmail1" placeholder="{{ old('company_code', $company->company_code) }}" name="company_code"></div>

    {{-- <div class="form-check">
      <input class="form-check-input" type="checkbox" name="status" value="active">
      <label class="form-check-label">Activate</label>
    </div> --}}
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>
@endsection