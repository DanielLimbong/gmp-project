<?php

namespace App\Http\Controllers;

use App\Charts\IssueChart;
use Illuminate\Http\Request;
use App\Models;
use App\Models\Area;
use App\Models\DailyInspectionSummary;
use App\Models\Issue;

class DashboardController extends Controller
{
    public function showDashboard(){
            $areas = Area::all();
            foreach($areas as $area)
            $issues = Issue::where('area_id', $area->id)
            ->where('status')
            ->get();

            $dailyInspectionSummaries = $issues->map(function ($issue) {
            return DailyInspectionSummary::find($issue->daily_inspection_summary_id);
            })->filter();

            return view('welcome', [
            'issues' => $issues,
            'dailyInspectionSummaries' => $dailyInspectionSummaries,
            'area' => $area,
            ]);

    }

        public function listIssue()
        {
            $areas = Area::all();
            foreach($areas as $area)
                $issues = Issue::where('area_id', $area->id)
                ->where('status')
                ->get();

        $dailyInspectionSummaries = $issues->map(function ($issue) {
        return DailyInspectionSummary::find($issue->daily_inspection_summary_id);
        })->filter();

        return view('dashboard', [
        'issues' => $issues,
        'dailyInspectionSummaries' => $dailyInspectionSummaries,
        'area' => $area,
        ]);
        }
}   
