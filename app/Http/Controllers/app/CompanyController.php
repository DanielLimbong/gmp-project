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
    public function getEditCompany(Company $company){
          
        return view ('company.edit', ['company' => $company]);
    }
    public function EditCompany(Request $request, Company $company){
        $companyCode = $request->input('company_code');

        $existingCompany = Company::where('company_code', $companyCode)
            ->where('id', '!=', $company->id)
            ->first();
        if($existingCompany === null){
            // $company
            $company->name = $request->input('name') ?: old('name', $company->name);
            $company->company_code = $request->input('company_code') ?: old('name', $company->company_code);
            $company->save();

            $companies = Company::all();
            Alert::success('success', 'Company updated successfully');
            return redirect()->route('company.list')->with('success', 'Company updated successfully!');
        }else{
            return redirect()->back()->with('error', 'Failed to update company. Please try again.')->withInput();
        }
        
    }

    public function storeCompany(Request $request){
                $companyCode = $request->input('company_code');

                $existingCompany = Company::where('company_code', $companyCode)
                // ->where('id', '!=', $company->id)
                ->first();
                if($existingCompany === null){
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
            }else{
                Alert::error('Error', 'Failed to create company. Please try
                again.');
            return redirect()->back()->with('error', 'Failed to create company. Please try
            again.')->withInput();
                            }
    }

        public function deleteCompany(Company $company){
        try{
        $company->deletion_indicator = "Yes";
        $company->save();
        Alert::success('Success', 'company deleted successfully')->autoClose(3000);
        return redirect()->route('company.list')->with('success', 'Company deleted successfully!');
        } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete company. Please try again.')->withInput();
        }
        }

            public function activateCompany(Company $company){
            try{
            $company->deletion_indicator = "No";
            $company->save();
            Alert::success('Success', 'Company activated successfully')->autoClose(3000);
            return redirect()->route('company.list')->with('success', 'Company activated successfully!');
            } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to activate company. Please try again.')->withInput();
            }
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
