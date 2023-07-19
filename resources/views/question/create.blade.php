@extends('template')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create Question</h3>
        </div>
        <form action="{{ route('question.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Textarea</label>
                    <textarea class="form-control" rows="3" placeholder="Enter Question" name="question"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Weight</label>
                    <input type="text" class="form-control" id="weight" placeholder="Enter weight" name="weight">
                </div>
                <div class="form-group">
                    <label for="exampleSelectBorder">Select Area</label>
                    <select class="custom-select form-control-border" id="exampleSelectBorder" name="area_id">
                        <option selected disabled hidden>Select Area</option>
                        @foreach ($areas as $item)
                            <option value="{{ $item->id }}">{{ $item->area_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="active" name="status">
                    <label for="customCheckbox1" class="custom-control-label">Activate Question</label>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
