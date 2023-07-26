@extends('template')
@section('header')
    <h2>Edit User</h2>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <form action="{{ route('user.put', $users) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleSelectBorder">Company</label>
                    <select class="custom-select form-control-border" id="exampleSelectBorder" name="company_code">
                        <option value="{{ $users->companies->company_code }}" selected disabled>{{ old('company_', $users->companies->name) }}</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->company_code }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">NIK</label>
                    <input type="text" class="form-control" id="nik" placeholder="{{ old('nik', $users->nik) }}" name="nik">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="weight" placeholder="{{ old('name', $users->name) }}" name="name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="weight" placeholder="{{ old('email', $users->email) }}" name="email">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Position</label>
                    <input type="text" class="form-control" id="weight" placeholder="{{ old('position', $users->position) }}" name="position">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Division</label>
                    <input type="text" class="form-control" id="weight" placeholder="{{ old('division', $users->division) }}" name="division">
                </div>
                <div class="form-group">
                    <label for="exampleSelectBorder">Roles</label>
                    <select class="custom-select form-control-border" id="exampleSelectBorder" name="role">
                        <option selected disabled hidden>{{ old('role', $users->role) }}</option>
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="Yes" name="deletion_indicator" <?php echo (old('deletion_indicator', $users->deletion_indicator) === 'Yes') ? 'checked' : ''; ?>>
                  <label for="customCheckbox1" class="custom-control-label" >Flag Deletion</label>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
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
@endsection
