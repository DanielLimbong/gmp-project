<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Company;
use App\Models\DailyInspectionSummary;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;

class ChartController extends Controller
{
        public function getAreaChartData(Request $request)
        {
        $areas = Area::all();
        $data = [];

        foreach ($areas as $area) {
        $dailyInspectionSummary = DailyInspectionSummary::where('area_id', $area->id)->count();
        $data['labels'][] = $area->area_name;
        $data['dataset'][] = $dailyInspectionSummary;
        }

        return response()->json($data);
        }
        public function getIssueChartData(Request $request)
        {
        $areas = Area::all();
        $data = [];

        foreach ($areas as $area) {
        $issues = Issue::where('area_id', $area->id)->count();
        $data['labels'][] = $area->area_name;
        $data['dataset'][] = $issues;
        }

        return response()->json($data);
        }
        public function getUserChartData(Request $request)
        {
        $companies = Company::all();
        $data = [];

        foreach ($companies as $company) {
        $users = User::where('company_code', $company->company_code)->count();
        $data['labels'][] = $company->name;
        $data['dataset'][] = $users;
        }

        return response()->json($data);
        }
}
