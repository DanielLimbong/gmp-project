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
                <a href="{{ route('answer.list', $area ) }}" class="btn btn-danger ml-2" style="width: 150px;"><i class="fas fa-chevron-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Question {{ $question->id }}
                </h3>
            </div>
            <div class="card-body">
                <blockquote>
                    <p>
                        {{ $question->question }}
                    </p>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Detail
                </h3>
            </div>
            <div class="card-body">
                <blockquote>
                    <small>Area <cite title="Source Title"> : </cite></small>
                    <p>
                        {{ $question->areas->area_name }}
                    </p>
                </blockquote>
                <blockquote>
                    <small>Weight <cite title="Source Title"> : </cite></small>
                    <p>
                        {{ $question->weight }}
                    </p>
                </blockquote>
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
                            <th>No</th>
                            <th>Answer</th>
                            <th>Point</th>
                            <th width=25>Score Point</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($answers as $answer)
                        <tr>
                            <td>{{ $answer->point }}</td>
                            <td style="overflow-wrap: break-word">{{ $answer->answer }}</td>
                            <td>{{ $answer->point }} point</td>
                            <td>{{ ($answer->point) * ($question->weight) }}</td>
                            <td class="project-actions text-right">
                                <div class="d-flex">
                                    <button class="btn btn-info ml-4" data-toggle="modal" data-target="#editModal{{ $answer->id }}">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <p class="text-muted text-right"><em>Score Point = Question Weight x Answer Point</em></p>
    </div>
</div>

@foreach ($answers as $answer)
<div class="modal fade" id="editModal{{ $answer->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $answer->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $answer->id }}">Edit Jawaban</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('answer.edit', $answer) }}" method="POST">
                    @csrf
                    {{-- @method('PUT') --}}
                      <div class="form-group">
                          <label for="editedAnswer{{ $answer->id }}">Jawaban:</label>
                          <textarea class="form-control" id="editedAnswer{{ $answer->id }}" name="text" style="width: 100%; height: 150px;">{{ $answer->answer }}</textarea>
                      </div>


                    <div class="form-group">
                        <label for="editedPoint{{ $answer->id }}">Point:</label>
                        <input type="number" class="form-control" id="editedPoint{{ $answer->id }}" name="point" value="{{ $answer->point }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@section('js')
    <script>
        let table = new DataTable('#answer_detail');
    </script>
@endsection
@endsection
