@extends('template')
@section('header')
    <h1>List Answer</h1>
@endsection
@section('content')
  <div class="col-md-3">
      <button type="button" class="btn btn-block btn-success btn-lg">
        <a class="text-white" href="{{ route('answer.create', $question) }}">+
            Create
            Answer
        </a>
    </button>
            <div class="card-header">
          <h3 class="card-title">{{ $question->text }}</h3>
        </div>
  </div>
  <br>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">


      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap" id="answer_detail">
          <thead>
            <tr>
              <th>No</th>
              <th>Answer</th>
              <th>Point</th>
              <th>Score Point</th>
              {{-- <th>Reason</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($answers as $answer)
            <tr>
              <td>{{ $answer->point }}</td>
              <td>{{ $answer->answer }}</td>
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