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
    }

public function closeIssue(Issue $issue){
    if ($issue->status !== 'Close') {
    // Ganti $issue->status menjadi "Close"
    $issue->status = 'Close';
    $issue->updater_id = auth()->user()->id;
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
}
