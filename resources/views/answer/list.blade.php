@extends('template')
@section('header')
    <h2>List Answer</h2>
@endsection
@section('content')
    <div class="container-xxl">
        <div class="row">
        <div class="col-12">

                <div class="row p-2">
                    <div class="col-12 p-2">
                        <div class="card p-2">
                            <!-- /.card-header -->
                <div class="card-body table-responsive p-2">
                    <table class="table table-hover text-nowrap" id="answer_question">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Weight</th>
                                <th>Area</th>
                                <th class="text-center">Action</th>
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
                                      <a class="btn btn-info view-area ml-4" href="{{ route('answer.detail', $row) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                         Manage Answer
                                      </a>
                                    </td>
                                    {{-- <td>{{ $row->numbering }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                        </div>
                    </div>
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
