<?php

namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function showProfile(){
        return view('auth.profile');
    }

    public function getChangePassword(User $user){
        return view('user.password');
    }
    public function ChangePassword(Request $request, User $user){
    
        if($request->input('password') === $request->input('confirm_password')){
            $password = Hash::make($request->input('password'));
            $userId = auth()->user()->id;
            User::where('id', $userId)->update(['password' => $password]);
            User::where('id', $userId)->update(['first_time' => '0']);
            // dd($user);
            Alert::success('success', 'Password changed successfully')->autoClose(3000);
            return redirect()->route('change.password')->with('success', 'Password changed successfully!');
        } 
        else{
        return redirect()->route('change.password')->with('error', 'Failed to change password. Please try again!');
        }
}
}
