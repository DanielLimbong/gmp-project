@extends('template')
@section('header')
    <h1>List Question</h1>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="answer_question">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Weight</th>
                                <th>Area</th>
                                <th></th>
                                {{-- <th>Numbering</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->question }}</td>
                                    <td>{{ $row->weight }}</td>
                                    <td>{{ $row->areas->area_name }}</td>
                                    <td class="project-actions text-center">
                                      <a class="btn btn-info btn-sm" href="{{ route('answer.detail', $row) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Answer
                                      </a>
                                    </td>
                                    {{-- <td>{{ $row->numbering }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>

                <!-- /.card-body -->

            </div>

            <!-- /.card -->

        </div>

    </div>
    @section('js')
    <script>
        let table = new DataTable('#answer_question');
    </script>
		@endsection
@endsection
