<?php

namespace App\Http\Controllers;

use App\Charts\IssueChart;
use Illuminate\Http\Request;
use App\Models;
use App\Models\Area;

class DashboardController extends Controller
{
    public function showDashboard(){

        $areas = Area::all();
        // $issuesChart = new IssueChart;
        // $issuesChart->labels([$areas->name]);
        // $issuesChart->dataset([]);
        return view('welcome');
    }
}   
