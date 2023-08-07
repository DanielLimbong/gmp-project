@extends('template')
@section('header')
    <h1>List Answer</h1>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            @foreach ($areas as $item)
                <div class="col-lg-4 col-6">

                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $item->area_name }}</h3>
                            <p>Maintain the {{ $item->area_name }} Answer</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('answer.list', $item) }}" class="small-box-footer">Go <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endforeach



           

        </div>

    </div>
@endsection
