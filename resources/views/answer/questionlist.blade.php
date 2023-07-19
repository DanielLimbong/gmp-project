@extends('template')
@section('header')
    <h1>List Question</h1>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Pertanyaan</h3>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-block btn-success btn-lg">
                            <a class="text-white" href="{{ route('question.create') }}">+
                                Create
                                Question</a>
                        </button>
                    </div>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Weight</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Numbering</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->question }}</td>
                                    <td>{{ $row->weight }}</td>
                                    <td>{{ $row->areas->area_name }}</td>
                                    <td>{{ $row->status }}</td>
                                    <td>{{ $row->numbering }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-sm-12 col-md-7">
                        <div class="pagination">
                            {{ $questions->links() }}
                        </div>
                    </div>

                </div>

                <!-- /.card-body -->

            </div>

            <!-- /.card -->

        </div>

    </div>
@endsection
