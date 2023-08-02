@extends('template')
@section('header')
    <h2>List Answer</h2>
@endsection
@section('content')
  <div class="container-xxl">
    <div class="row">
        <div class="col text-right">
            <div class="d-flex justify-content-end pr-2">
                <a href="{{ route('answer.create', $question) }}" class="btn btn-success ml-2" style="width: 150px;">
                    <i class="fas fa-plus"></i> Create
                </a>
            </div>
        </div>
    </div>
</div>
  <br>
  <div class="row p-2">
    <div class="col-12 p-2">
      <div class="card p-2">


      <div class="card-body table-responsive p-2">
        <table class="table table-hover" style="width: 100%" id="answer_detail">
          <thead>
            <tr>
              <th >No</th>
              <th >Answer</th>
              <th >Point</th>
              <th width=25>Score Point</th>
              {{-- <th>Reason</th> --}}
            </tr>
          </thead>
          <tbody>

            @foreach ($answers as $answer)
            <tr>
              <td>{{ $answer->point }}</td>
              <td style="overflow-wrap: break-word">{{ $answer->answer }}</td>
              <td>{{ $answer->point }} point</td>
              <td>{{ ($answer->point)*($question->weight) }}</td>
              {{-- <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td> --}}
            </tr>
            @endforeach


          </tbody>
        </table>
        
      </div>

      </div>
        <p class="text-muted text-right"><em>Score Point = Question Weight x Answer Point</em></p>
    </div>
</div>
@section('js')
    <script>
        let table = new DataTable('#answer_detail');
    </script>
		@endsection
@endsection