@extends('template')
@section('header')
    <h2>Edit Area</h2>
@endsection
@section('content')
<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Create Area</h3>
	</div>
	<form action="{{ route('area.post', $area) }}" method="POST">
		@csrf
		<div class="card-body">
    <div class="form-group">
        <label for="exampleInputEmail1">Area Name</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="{{ $area->area_name }}" name="name" value="{{ old('name', $area->area_name) }}">
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="status" value="active" placeholder="{{ $area->status }}" {{ $area->status === 'active' ? 'checked' : '' }}>
        <label class="form-check-label">Activate</label>
    </div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Edit</button>
		</div>
	</form>
</div>
@endsection