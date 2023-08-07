@extends('template')

@section('header')
    <h2>Create User</h2>
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create User</h3>
        </div>
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="card-body">
                {{-- <div class="form-group">
                    <label>Textarea</label>
                    <textarea class="form-control" rows="3" placeholder="Enter Question" name="question"></textarea>
                </div> --}}
                <div class="form-group">
                    <label for="exampleSelectBorder">Select Company</label>
                    <select class="custom-select form-control-border" id="exampleSelectBorder" name="company_code" aria-placeholder="Select Company">
                        {{-- <option disabled hidden>Select Company</option> --}}
                        @foreach ($companies as $company)
                            <option value="{{ $company->company_code }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">NIK</label>
                    <input type="text" class="form-control" id="weight" placeholder="Enter NIK" name="nik">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="weight" placeholder="Enter Name" name="name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="weight" placeholder="Enter Email" name="email">
                </div>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                  <div class="input-group-append p-2">
                    <button class="btn btn-outline-secondary" type="button" id="showPasswordBtn" onclick="togglePasswordVisibility()">
                      Show
                    </button>
                  </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="Enter Password" name="confirm_password">
                    <div class="input-group-append p-2">
                    <button class="btn btn-outline-secondary" type="button" id="showPasswordBtn" onclick="togglePasswordVisibility()">
                      Show
                    </button>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Position</label>
                    <input type="text" class="form-control" id="position" placeholder="Enter Position" name="position">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Division</label>
                    <input type="text" class="form-control" id="division" placeholder="Enter Division" name="division">
                </div>
                <div class="form-group">
                    <label for="exampleSelectBorder">Select Roles</label>
                    <select class="custom-select form-control-border" id="exampleSelectBorder" name="roles">
                        <option value="Administrator">Administrator</option>
                        <option value="Reviewer as MIP">Reviewer as MIP</option>
                        <option value="Reviewer as Contractor">Reviewer as Contractor</option>
                        <option value="Operational Team">Operational Team</option>
                        {{-- @foreach ($areas as $item)
                            <option value="{{ $item->id }}">{{ $item->area_name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="Yes" name="deletion_indicator">
                    <label for="customCheckbox1" class="custom-control-label">Flag Deletion</label>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
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
      Swal.fire(
        'Success',
        'User created successfully',
        'success'
    ).then((result) => {
        // Redirect or do something else
    });
</script>