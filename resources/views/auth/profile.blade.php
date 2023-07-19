@extends('template')

@section('header')
    
@endsection

@section('content')
  <div class="card-body row">
	<div class="col-5 text-center d-flex align-items-center justify-content-center">
		<div class="">
			<h2>Mandiri <strong class="text-danger">Coal</strong></h2>
			<p class="lead mb-5">
				Jl. Senopati No.8,
        RT.8/RW.3, Senayan, Kec. Kebayoran.
        Baru, Kota Jakarta Selatan, Daerah
        Khusus Ibukota Jakarta 12190<br>Phone: 021 – 29333189 / 29333190</p>
		</div>
	</div>
	<div class="col-7">
		<div class="form-group">
			<label for="inputName">Name</label>
			<input type="text" id="inputName" class="form-control" disabled></div>
		<div class="form-group">
			<label for="inputEmail">E-Mail</label>
			<input type="email" id="inputEmail" class="form-control" disabled></div>
		<div class="form-group">
			<label for="inputSubject">Company</label>
			<input type="text" id="inputSubject" class="form-control" disabled></div>
		{{-- <div class="form-group">
			<label for="inputMessage">Message</label>
			<textarea id="inputMessage" class="form-control" rows="4"></textarea>
		</div> --}}
		<div class="form-group">
			<a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
	</div>
</div>
@endsection