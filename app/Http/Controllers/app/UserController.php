<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function getUserList(){
        $users = User::all();

        return view('user.list', ['users' => $users]);
    }

    public function getAreaList(){
        $areas = Area::all();

        return view('user.area', ['areas' => $areas]);
    }

    public function getCreateUser(){
        $companies = Company::all();
        $companies = Company::all();
        return view ('user.create', ['companies' => $companies]);
    }

    public function viewUser(User $user){
        $users = User::where('id', '=', '$user->id')->get();

        return view('user.view', ['users' => $user]);
    }

    public function storeUser(Request $request){
        // dd($request);
        try{
        $validatedData = $request->validate([
        'company_code' => 'required',
        'nik' => 'required',
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'position' => 'required',
        'division' => 'required',
        'roles' => 'required',
        'deletion_indicator' => 'nullable',
        ]);

        $user = new User();
        $user->id = $request->input('company_code'). "-" . $request->input('nik');
        $user->company_code = $request->input('company_code');
        $user->nik = $request->input('nik');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->position = $request->input('position');
        $user->division = $request->input('division');
        $user->role = $request->input('role');
        $user->deletion_indicator = $request->has('deletion_indicator') ? 'Yes' : 'No';
        // dd($user);
        $user->save();
        Alert::success('Success', 'User created successfully')->autoClose(3000);
        return redirect()->route('user.detail')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create user. Please try again.')->withInput();
        // dd($user);
        }
    }
    public function getEditUser(User $user){
        // $users = User::where('id', '=', '$user->id')->get();
        $areas = Area::all();
        $companies = Company::all();

        return view('user.edit', ['users' => $user, 'areas' => $areas, 'companies' => $companies]);
    }

    public function editUser(Request $request, User $user)
    {
    try {
   $user->company_code = $request->input('company_code') ?: old('company_code', $user->company_code);
   $user->nik = $request->input('nik') ?: old('nik', $user->nik);
   $user->name = $request->input('name') ?: old('name', $user->name);
   $user->email = $request->input('email') ?: old('email', $user->email);
   // Password field is not updated here to keep the existing password
   $user->position = $request->input('position') ?: old('position', $user->position);
   $user->division = $request->input('division') ?: old('division', $user->division);
   $user->role = $request->input('role') ?: old('role', $user->role);
   $user->deletion_indicator = $request->has('deletion_indicator') ? 'Yes' : 'No';

    $user->save();

    Alert::success('Success', 'User updated successfully')->autoClose(3000);
    return redirect()->route('user.detail')->with('success', 'User updated successfully!');
    } catch (\Exception $e) {
    return redirect()->back()->with('error', 'Failed to update user. Please try again.')->withInput();
    }
    }

    public function deleteUser(User $user){
        try{
        $user->deletion_indicator = "Yes";
        $user->save();
            Alert::success('Success', 'User deleted successfully')->autoClose(3000);
            return redirect()->route('user.detail')->with('success', 'User deleted successfully!');
            } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user. Please try again.')->withInput();
            }
    }
    public function activateUser(User $user){
        try{
        $user->deletion_indicator = "No";
        $user->save();
            Alert::success('Success', 'User activated successfully')->autoClose(3000);
            return redirect()->route('user.detail')->with('success', 'User activated successfully!');
            } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to activated user. Please try again.')->withInput();
            }
    }

    // public function questionIndex($area_id){
    // $questions = Question::where('area_id', $area_id)->get();
    // return response()->json($questions);
    // }
    
}
