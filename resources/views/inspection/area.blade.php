@extends('template')
@section('header')
    <h1>List Inspection</h1>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            @foreach ($areas as $item)
                <div class="col-lg-4 col-6">

                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>{{ $item->area_name }}</h3>
                            <p>Maintain the {{ $item->area_name }} Daily Inspection</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('inspection.show', $item) }}" class="small-box-footer">Go <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endforeach           

        </div>

    </div>
@endsection
