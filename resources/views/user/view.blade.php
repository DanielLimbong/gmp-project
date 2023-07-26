@extends('template')
@section('header')
    <h2>View User</h2>
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">View User</h3>
        </div>
        <form action="{{ route('question.store') }}" method="POST">
            @csrf
            <div class="card-body">
                {{-- <div class="form-group">
                    <label>Textarea</label>
                    <textarea class="form-control" rows="3" placeholder="Enter Question" name="question"></textarea>
                </div> --}}
                <div class="form-group">
                    <label for="exampleSelectBorder">Company</label>
                    <select class="custom-select form-control-border" id="exampleSelectBorder" name="area_id" disabled>
                        <option selected disabled >{{ $users->company_code }}</option>
                        {{-- @foreach ($companies as $company)
                            <option value="{{ $company->code }}">{{ $company->name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">NIK</label>
                    <input type="text" class="form-control" id="nik" placeholder="{{ $users->nik }}" name="nik" disabled>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="weight" placeholder="{{ $users->name }}" name="weight" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="weight" placeholder="{{ $users->email }}" name="weight" disabled>
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Position</label>
                    <input type="text" class="form-control" id="weight" placeholder="{{ $users->position }}" name="weight" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Division</label>
                    <input type="text" class="form-control" id="weight" placeholder="{{ $users->division }}" name="weight" disabled>
                </div>
                <div class="form-group">
                    <label for="exampleSelectBorder">Roles</label>
                    <select class="custom-select form-control-border" id="exampleSelectBorder" name="area_id" disabled>
                        <option selected disabled hidden>{{ $users->role }}</option>
                        {{-- @foreach ($areas as $item)
                            <option value="{{ $item->id }}">{{ $item->area_name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="active" name="status" <?php echo ($users->deletion_indicator === 'Yes') ? 'checked' : ''; ?> disabled>
                  <label for="customCheckbox1" class="custom-control-label" >Flag Deletion</label>
                </div>
            </div>

            {{-- <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div> --}}
        </form>
    </div>
@endsection
<script>
  function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var showPasswordBtn = document.getElementById("showPasswordBtn");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPasswordBtn.textContent = "Hide";
    } else {
      passwordInput.type = "password";
      showPasswordBtn.textContent = "Show";
    }
  }
</script>