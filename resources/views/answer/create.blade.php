@extends('template')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create Answer</h3>
        </div>
        <form action="{{ route('answer.store', $question) }}" method="POST">
            @csrf
            <div class="card-body">
                  <div class="form-group">
                      <label>Question</label>
                      <textarea class="form-control" rows="3" placeholder=" {{ $question->question }}" name="question" disabled></textarea>
                  </div>

                  <div class="form-group">
                      <label>Input Answer</label>
                      <textarea class="form-control" rows="3" placeholder="Enter Question" name="text"> {{ $question->text }}</textarea>
                  </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Point</label>
                    <input type="text" class="form-control" id="weight" placeholder="Enter point" name="point">
                </div>


            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
