@extends('template')

@section('header')
    <h1>Daily Inspection Detail</h1>
@endsection

@section('content')

    <div class="card p-2">
    <div class="row">
        <div class="col-md-6">
            <div class="card p-2 w-100">
                <!-- Isi card pertama -->
                <table class="table-sm">
                    <tr>
                        <th class="vertical-header">Daily Inspection Code</th>
                        <td>:</td>
                        <td>{{ $dailyInspectionSummary->id }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-header">Created By</th>
                        <td>:</td>
                        <td>{{ $dailyInspectionSummary->users->name }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-header">Company</th>
                        <td>:</td>
                        <td>{{ $dailyInspectionSummary->users->companies->name }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-header">Date</th>
                        <td>:</td>
                        <td>{{ $dailyInspectionSummary->created_at->formatLocalized('%d %B %Y') }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-header">Time</th>
                        <td>:</td>
                        <td>{{ $dailyInspectionSummary->created_at->format('H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-2 justify-content-end" style="background-color: #00aaff00;">
                <!-- Isi card kedua -->
                <div class="container-xxl">
                    <div class="row p-2">
                        <div class="col justify-content-end text-center p-2">
                            <div class="d-flex p-2 text-right">
                                <button class="btn btn-primary ml-2" style="width: 300px;">
                                    <h5>Score Total: {{ $dailyInspectionSummary->score_total }}</h5>
                                </button>
                            </div>
                            <div class="d-flex">
                                @if ($dailyInspectionSummary->status === 'Approved')
                                    <a class="btn btn-info ml-2 d-flex align-items-center justify-content-center"
                                        style="width: 150px; pointer-events: none; opacity: 0.5; cursor: not-allowed;">
                                        Update Point
                                    </a>
                                @else
                                    <a class="btn btn-info ml-2 d-flex align-items-center justify-content-center"
                                        style="width: 150px; cursor: pointer;"
                                        href="{{ route('inspection.update-point') }}">
                                        Update Point
                                    </a>
                                @endif

                                @if ($dailyInspectionSummary->status === 'Approved') 
                                    <button class="btn btn-success ml-2" style="width: 150px;" disabled> Approved</button>
                                @else
                                    <button class="btn btn-success ml-2" style="width: 150px;"> Approved</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card p-2 col-12">
            <div class="row">

            <div class="card-body table-responsive p-2" style="height: 450px;">
                <table class="table table-head-fixed text-nowrap p-2" id="inpection_detail">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Score Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inspectionsDetail->sortBy('questions.numbering') as $inspection)
                            <tr>
                                <td>{{ $inspection->questions->question }}</td>
                                <td>{{ Str::limit($inspection->answers->answer, 50) }}</td>
                                <td>{{ $inspection->questions->weight * $inspection->answers->point }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        // let table = new DataTable('#inpection_detail');
                // let table = new DataTable('#user_table');
				$(document).ready(function() {
				$('#inpection_detail').DataTable( {
						dom: 'Bfrtip',
						buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
						]
				} );
		} );
    </script>
@endsection
