<?php

namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

public function login(Request $request)
{
$credentials = $request->validate([
'email' => 'required|email',
'password' => 'required',
]);

$user = User::where('email', $credentials['email'])->first();

if ($user) {
if (Hash::check($credentials['password'], $user->password)) {
// Password cocok, autentikasi berhasil
Auth::login($user);
return redirect()->route('dashboard');
} else {
// Password tidak cocok, autentikasi gagal
return back()->withErrors([
'email' => 'Email atau password yang Anda masukkan salah.',
]);
}
} else {
// Pengguna tidak ditemukan, autentikasi gagal
return back()->withErrors([
'email' => 'Email atau password yang Anda masukkan salah.',
]);
}
}

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

public function apklogin(Request $request)
{
$credentials = $request->only('email', 'password');

if (Auth::attempt($credentials)) {
$token = JWTAuth::attempt($credentials);
$user = User::where('email', $request->email)->first(); // Menggunakan metode "find"

if ($user) {
return response()->json([
// 'access_token' => $token,
// 'user' => [
// 'id' => $user->id,
// 'company_code' => $user->company_code,
// 'access_token' => $token,
// 'nik' => $user->nik,
// 'name' => $user->name,
// 'email' => $user->email,
// 'role' => $user->role,
// 'email_verified_at' => $user->email_verified_at,
// 'created_at' => $user->created_at,
// 'updated_at' => $user->updated_at,
// 'position' => $user->position,
// 'division' => $user->division,
// 'deletion_indicator' => $user->deletion_indicator,
// ]
'access_token' => $token, 'user' => $user
], 200);
} else {
return response()->json(['error' => 'User not found'], 404);
}
} else {
return response()->json(['error' => 'Unauthorized'], 401);
}
}



}
