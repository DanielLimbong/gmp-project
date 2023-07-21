<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Area;
use App\Models\Company;
use App\Models\Daily_Inspection_Summary;
use App\Models\DailyInspection;
use App\Models\DailyInspectionSummary;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    public function showInspection(Area $area)
    {
        $dailyInspectionSummaries = DailyInspectionSummary::where('area_id', $area->id)->get();
        $userIds = $dailyInspectionSummaries->pluck('user_id')->toArray();
        $users = User::whereIn('id', $userIds)->get();
        $companyCodes = $users->pluck('company_code')->toArray(); // Ambil semua kode perusahaan dari pengguna
        $companies = Company::whereIn('company_code', $companyCodes)->get(); // Ambil perusahaan berdasarkan kode perusahaan
        // dd($companies);

        return view('inspection.show', ['dailyInspectionSummaries' => $dailyInspectionSummaries, 'users' => $users, 'area' => $area, 'companies' => $companies]);
    }



    public function inspectionDetail(DailyInspectionSummary $dailyInspectionSummary){
        $inspectionsDetail = DailyInspection::where('daily_inspection_summary_id', '=', $dailyInspectionSummary->id)->get();
        // $inspectionsDetail = DailyInspection::all();
        $questionIds = $inspectionsDetail->pluck('question_id')->toArray();
        $answerIds = $inspectionsDetail->pluck('answer_id')->toArray();
        $question = Question::whereIn('id', $questionIds)->orderBy('numbering')->get();
        $answers = Answer::whereIn('id', $answerIds)->get();
        return view('inspection.detail', ['inspectionsDetail' => $inspectionsDetail, 'dailyInspectionSummary' => $dailyInspectionSummary, 'question' => $question, 'answer' => $answers]);
    }

    public function inspectionArea(){
            $areas = Area::all();

            return view('inspection.area', compact('areas'));
    }

    public function getUpdatePoint(){
        return view ('inspection.update-point');

    }
    public function inspectionIndex(){
    $inspections = DailyInspectionSummary::all();
    return response()->json($inspections);
    }

    public function storeInspection(Request $request)
    {
        $inspectionData = $request->all();
        $total = 0;

        foreach ($inspectionData as $item) {
        $question = Question::find($item['question_id']);
        $answer = Answer::find($item['answer_id']);

        if ($question && $answer) {
        $area = Area::find($question->area_id);

        if ($area) {
        $result = $question->weight * $answer->point;
        $total += $result;
        } else {
        // Jika area tidak ditemukan
        return response()->json(['message' => 'Invalid area data'], 400);
        }
        } else {
        // Jika pertanyaan atau jawaban tidak ditemukan
        return response()->json(['message' => 'Invalid question or answer data'], 400);
        }
        }

        $areaId = $question->area_id;
        $prefix = date('y') . 'DI' . str_pad($areaId, 3, '0', STR_PAD_LEFT);
        $id = IdGenerator::generate(['table' => 'daily_inspection_summaries', 'length' => 13, 'prefix' => $prefix]);
        $dailyInspectionSummary = new DailyInspectionSummary;
        $dailyInspectionSummary->id = $id;
        $dailyInspectionSummary->created_at = $item['created_at'];
        $dailyInspectionSummary->updated_at = $item['created_at'];
        $dailyInspectionSummary->user_id = $item['user_id'];
        $dailyInspectionSummary->area_id = $areaId;
        $dailyInspectionSummary->score_total = $total;
        $dailyInspectionSummary->status = "NA";
        // dd($dailyInspectionSummary);
        

        $dailyInspectionSummary->save();

        foreach ($inspectionData as $item) {
        $question = Question::find($item['question_id']);
        $answer = Answer::find($item['answer_id']);
        $score_point = $question->weight * $answer->point;

        if ($question && $answer) {
        $area = Area::find($question->area_id);

        if ($area) {
        // $result = $question->weight * $answer->point;
        // $total += $result;
        $dailyInspection = new DailyInspection();
        $dailyInspection->daily_inspection_summary_id = $id;
        $dailyInspection->question_id = $item['question_id'];
        $dailyInspection->answer_id = $item['answer_id'];
        $dailyInspection->score_point = $score_point;
        $dailyInspection->created_at = strtotime($item['created_at']);
        $dailyInspection->updated_at = null;
        $dailyInspection->save();


        } else {
        // Jika area tidak ditemukan
        return response()->json(['message' => 'Invalid area data', 'id' => $id], 400);
        }
        } else {
        // Jika pertanyaan atau jawaban tidak ditemukan
        return response()->json(['message' => 'Invalid question or answer data'], 400);
        }
        }
                

        return response()->json(['message' => "Daily Inspection Created!"], 200);
    }


}
