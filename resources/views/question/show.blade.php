@extends('template')
@section('header')
    <h1>List Area</h1>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            @foreach ($areas as $item)

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $item->area_name }}</h3>
                            <p>Maintain the {{ $item->area_name }} Question</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        {{-- @php
                            $item = \Haruncpi\LaravelIdGenerator\IdGenerator::generate(['table' => 'areas', 'length' => 3, 'prefix' => date('A')]);
                            $route = route('question.list', ['area' => $item]);
                        @endphp --}}

                        <a href="{{ route('question.list', $item )}}" class="small-box-footer">Go <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-4 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>All</h3>
                        <p>Maintain All Question</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


            {{-- <div class="col-lg-4 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Front Loading Coal</h3>
                        <p>Maintain the Front Loading Coal Question</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 class="text-light">Dewatering</h3>
                        <p class="text-light">Maintain the Dewatering Question</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-6">

                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>Disposal</h3>
                        <p>Maintain the Disposal Question</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">

                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>Haul Road</h3>
                        <p>Maintain the Haul Road Question</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">Go <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}

        </div>

    </div>
@endsection
