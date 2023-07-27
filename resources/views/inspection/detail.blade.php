@extends('template')

@section('header')
    <h1>Daily Inspection Detail</h1>
@endsection

@section('content')

    <div class="card p-2">
    <div class="row">
        <div class="col-md-8">
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
        <div class="col-md-4">
            <div class="card p-2 justify-content-end" style="background-color: #00aaff00;">
                <!-- Isi card kedua -->
                <div class="container-xxl">
                    <div class="row p-2">
                        <div class="col justify-content-end text-center p-2">
                            <div class="">
                                        <div class="card" style="">
                                            <div class="card-body">
                                                <h4 class="text-center">Score Total : {{ $dailyInspectionSummary->score_total }}</h4>
                                            </div>
                                        </div>                      
                                    </div>
                            <div class="d-flex">
                                @if ($dailyInspectionSummary->status === 'Approved')
                                    <button class="btn btn-info ml-2 form-control" disabled>
                                        Update Point
                                    </button>
                                @else
                                    <button class="btn btn-info ml-2 form-control" data-toggle="modal" data-target="#updatePointModal">
                                        Update Point
                                    </button>
                                @endif

                                @if ($dailyInspectionSummary->status === 'Approved') 
                                    <button class="btn btn-success ml-2 form-control"  disabled> Approved</button>
                                @else
                                    <form action="{{ route("update.status", $dailyInspectionSummary) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success ml-2 form-control"  type="submit"> Approved</button>
                                    </form>    
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
    <div class="modal fade" id="updatePointModal" tabindex="-1" role="dialog" aria-labelledby="updatePointModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePointModalLabel">Update Score Point</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route("update.point", $dailyInspectionSummary) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="scorePoint">New Score Point:</label>
                            {{-- <input type="number" class="form-control" id="scorePoint" name="score_point" value="{{ $dailyInspectionSummary->score_point }}" placeholder="{{ $dailyInspectionSummary->score_point }}" required> --}}
                            <input type="number" class="form-control" id="scorePoint" name="score_point"  value="{{ $dailyInspectionSummary->score_total }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
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
