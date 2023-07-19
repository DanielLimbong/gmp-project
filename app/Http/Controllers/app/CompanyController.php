<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Area;
use App\Models\Company;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use RealRashid\SweetAlert\Facades\Alert;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function getCompany(){
        $companies = Company::all();
        return view ('company.list', ['companies' => $companies]);
    }

    public function createCompany(){
        return view ('company.create');
    }

    public function storeCompany(Request $request){
        $id = IdGenerator::generate(['table' => 'companies', 'length' => 4, 'prefix' => date('C')]);
        // $formattedId = sprintf("%03d", $id);
        $company = new Company;
        $company->id = $id;
        $company->name = $request->name;
        $company->company_code = $request->company_code;
        $company->save();
    
    
    Alert::success('Success', "Company Created!");
    // $request->session()->flash('success', 'Company Created!');
    return redirect()->route('company.list')->with('success', 'Company Created!');
    }

    public function apiStoreCompany(Request $request)
    {
        $data = $request->json()->all();

        foreach ($data as $item) {
        $id = IdGenerator::generate(['table' => 'companies', 'length' => 4, 'prefix' => date('C')]);

        $company = new Company;
        $company->id = $id;
        $company->name = $item['name'];
        $company->company_code = $item['company_code'];
        $company->save();
        }

        return response()->json(['message' => 'Companies stored successfully'], 200);
    }

}
