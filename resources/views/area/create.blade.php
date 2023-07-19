@extends('template')
@section('header')
    <h2>Create Area</h2>
@endsection
@section('content')
<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Create Area</h3>
	</div>
	<form action="{{ route('area.store') }}" method="POST">
		@csrf
		<div class="card-body">
			<div class="form-group">
				<label for="exampleInputEmail1">Area Name</label>
				<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter area name" name="name"></div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="status" value="active">
      <label class="form-check-label">Activate</label>
    </div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Create</button>
		</div>
	</form>
</div>
@endsection