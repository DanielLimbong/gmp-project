@extends('template')
@section('header')
    <h1>Preview Question</h1>
@endsection

@section('content')
<div class="p-2">
        <div class="p-2 d-flex justify-content-end">
            <div class="col-md-auto p-2">
                <a class="text-white btn btn-block btn-success btn-lg" href="{{ route('question.numbering', $area) }}">+
                    Set Numbering
                </a>
                <a class="text-white btn btn-block btn-primary btn-lg" href="{{ route('question.list', $area) }}">
                    Question List
                </a>
            </div>
        </div>


    <div class="card p-2">
            @foreach ($questions as $question)
        <div class="form-group">
            <label for="exampleInputBorderWidth2">Question Number {{ $question->numbering }}</label>
                <input type="text" class="form-control form-control-border border-width-2 disabled" id="exampleInputBorderWidth2" placeholder="{{ $question->question }}" disabled>
            @foreach ($question->answers as $answer)
                        <div class="form-check">
                <input class="form-check-input" type="radio" name="radio1" disabled>
                    <label class="form-check-label">{{ $answer->answer }}</label>
            </div>
                
            @endforeach

        </div> 
    @endforeach
    </div>
</div>
    


@endsection