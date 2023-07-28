@extends('template')

@section('header')
    <h2>Change Password</h2>
@endsection

@section('content')
@if(session('success'))
    <script>
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
})

Toast.fire({
  icon: 'success',
  title: '{{ session('success') }}'
})
    </script>
    @elseif (session('error'))
        <script>
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
})

Toast.fire({
  icon: 'error',
  title: '{{ session('error') }}'
})
    </script>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="login-box">
                <div class="login-logo">
                    <a href="#"><b>GMP</b>Sys</a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">
                            You are only one step a way from your new password, recover your password now.
                        </p>
                        <form action="{{ route('store.password') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="toggle-password fas fa-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="toggle-password fas fa-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Change password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Fungsi untuk menampilkan atau menyembunyikan password
        $(".toggle-password").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).parent().parent().prev()[0]);
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    });
</script>
@endsection
