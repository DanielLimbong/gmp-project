<?php

namespace App\Http\Controllers\app;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Company;
use App\Models\DailyInspectionSummary;
use App\Models\Issue;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class IssueController extends Controller
{
    public function showIssues(DailyInspectionSummary $dailyInspectionSummary){
        $issues = Issue::where('daily_inspection_summary_id', $dailyInspectionSummary->id)->get();
        $userIds = $issues->pluck('user_id')->toArray();
        $users = User::whereIn('id', $userIds)->get();
        $updaterIds = $issues->pluck('updated_id')->toArray();
        $updaters = User::whereIn('id', $updaterIds)->get();
        $companyCodes = $users->pluck('company_code')->toArray(); // Ambil semua kode perusahaan dari pengguna
        $companies = Company::whereIn('company_code', $companyCodes)->get(); // Ambil perusahaan berdasarkan kode perusahaan
        // dd($companies);

        return view('issue.detail', ['issues' => $issues, 'users' => $users,'dailyInspectionSummary' => $dailyInspectionSummary, 'companies' => $companies, 'updaters' => $updaters]);
    }

    public function showListArea(){
        $areas = Area::all();
        return view('issue.select-area', ['areas' => $areas]);
        }

    public function showInspectionIssue(Area $area)
    {
        $dailyInspectionSummaries = DailyInspectionSummary::where('area_id', $area->id)->get();
        $userIds = $dailyInspectionSummaries->pluck('user_id')->toArray();
        $users = User::whereIn('id', $userIds)->get();
        $companyCodes = $users->pluck('company_code')->toArray(); // Ambil semua kode perusahaan dari pengguna
        $companies = Company::whereIn('company_code', $companyCodes)->get(); // Ambil perusahaan berdasarkan kode perusahaan
        // dd($companies);

        return view('issue.select-inspection', ['dailyInspectionSummaries' => $dailyInspectionSummaries, 'users' => $users, 'area'
        => $area, 'companies' => $companies]);
    }

    public function issueShow(Issue $issue){
         $dailyInspectionSummary = DailyInspectionSummary::where('id', $issue->daily_inspection_summary_id)->first();
        return view('issue.show', ['issue' => $issue, 'dailyInspectionSummary' => $dailyInspectionSummary]);
    }public function listIssue(Area $area)
    {
        $issues = Issue::where('area_id', $area->id)->get();

        $dailyInspectionSummaries = $issues->map(function ($issue) {
        return DailyInspectionSummary::find($issue->daily_inspection_summary_id);
        })->filter();

        return view('issue.list', [
        'issues' => $issues,
        'dailyInspectionSummaries' => $dailyInspectionSummaries,
        'area' => $area,
        ]);
    }


public function closeIssue(Request $request, Issue $issue){
    if ($issue->status !== 'Close') {
    // Ganti $issue->status menjadi "Close"
    $issue->status = 'Close';
    $issue->updater_id = auth()->user()->id;
    $issue->closed_reason = $request->input('closed_reason');
                if ($request->hasFile('closed_photo')) {
                $photoName = $request->file('closed_photo')->getClientOriginalName();
                $photoPath = 'apkImages/' . $photoName;

                // Save the photo path to the issue record in the database
                $issue->image_closed = $photoPath;
                $issue->save();

                // Move the uploaded file to the desired directory
                $request->file('closed_photo')->move(public_path('apkImages'), $photoPath);

                }
    // $issue->save();
    
    // Simpan perubahan ke dalam database
    $issue->save();

    // Tambahkan kode tambahan di sini jika Anda ingin melakukan hal lain setelah menutup issue
    // Misalnya, mengganti $issue->updater_id menjadi ID user yang sedang login:
    // $issue->updater_id = auth()->user()->id;
    // $issue->save();
    Alert::success('Success', 'Issue Closed!')->autoClose(3000);
    return redirect()->back()->with('success', 'Issue has been closed successfully.');
    } else {
    return redirect()->back()->with('error', 'The issue is already closed.');
    }
    }

    public function onprogressIssue(Request $request, Issue $issue)
    {
    // Update the issue's status to "On Progress"
    $issue->status = 'On Progress';
    $issue->updater_id = auth()->user()->id;
    $issue->closed_reason = $request->input('onprogress_reason');
    // ... other closing logic ...
    $issue->save();

    Alert::success('Success', 'Issue updated to On Progress.')->autoClose(3000);
    return redirect()->back()->with('success', 'Issue updated to On Progress.');
    }

}
