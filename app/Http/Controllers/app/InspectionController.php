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
use RealRashid\SweetAlert\Facades\Alert;
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

    public function updateStatus(DailyInspectionSummary $dailyInspectionSummary){
        try{
        $dailyInspectionSummary->status = "Approved";
        $dailyInspectionSummary->save();
        Alert::success('success', 'Status Updated!')->autoClose(3000);
        return redirect()->route("inspection.detail", $dailyInspectionSummary)->with('success', 'Status Updated!');
        } catch (\Exception $e) {
        return redirect()->route("inspection.detail", $dailyInspectionSummary)->with('error', 'Failed to update status.
        Please try again.')->withInput();
        }
    }

    public function updatePoint(Request $request, DailyInspectionSummary $dailyInspectionSummary){
        try{
        $dailyInspectionSummary->score_total = $request->input('score_point');
        $dailyInspectionSummary->status = "Approved";
        $dailyInspectionSummary->save();
        Alert::success('success', 'Score Total Updated!')->autoClose(3000);
        return redirect()->route("inspection.detail", $dailyInspectionSummary);
        } catch (\Exception $e) {
        return redirect()->route("inspection.detail", $dailyInspectionSummary)->with('error', 'Failed to update Score Total.
        Please try again.')->withInput();
        }
    }

    public function storeInspection(Request $request)
    {
        $inspectionData = $request->all();
        $total = 0;

        foreach ($inspectionData as $item) {
        $question = Question::find($item['question_id']);
        $answer = Answer::find($item['answer_id']);
        // if ($request->hasFile('image')) {
        //     $uploadedImage = $request->file('image');
        //     $imageName = uniqid() . '.' . $uploadedImage->getClientOriginalExtension();
        //     $imagePath = 'apkImages/' . $imageName;
        //     $uploadedImage->move(public_path('apkImages'), $imageName);
        //     $imageUrl = url('apkImages/' . $imageName);

        //     // Tambahkan URL gambar ke dalam data inspeksi
        //     $item['image'] = $imageUrl;
        // }

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

       $lastId = DailyInspectionSummary::where('id', 'LIKE', "$prefix%")->orderBy('id', 'desc')->first();
       $lastNumber = ($lastId) ? (int) substr($lastId->id, -6) : 0;

       $newNumber = $lastNumber + 1;
       $newNumberPadded = str_pad($newNumber, 6, '0', STR_PAD_LEFT);

       $newId = $prefix . $newNumberPadded;

       // Sekarang kita memiliki ID yang belum ada dalam basis data
       // Lanjutkan dengan membuat entri baru
       $dailyInspectionSummary = new DailyInspectionSummary;
       $dailyInspectionSummary->id = $newId;
       $dailyInspectionSummary->created_at = $item['created_at'];
       $dailyInspectionSummary->updated_at = $item['created_at'];
       $dailyInspectionSummary->user_id = $item['user_id'];
       $dailyInspectionSummary->area_id = $areaId;
       $dailyInspectionSummary->score_total = $total;
       $dailyInspectionSummary->status = "NA";
       $dailyInspectionSummary->location = $item['location'];
       
       $imageBit = $item['image_bytes'];
       $image = imagecreatefromstring(pack('C*', ...$imageBit));
       
       $imagePath = 'inspection/';

       // Dapatkan path ke direktori publik
       $publicPath = public_path($imagePath);
       $extension = 'jpg';
       $imageFilename = $newId . '.' . $extension;
       $imageFullPath = $publicPath . $imageFilename;
       
       // Simpan gambar dalam format JPEG
       imagejpeg($image, $imageFullPath, 95); // Simpan gambar dalam format JPEG dengan kualitas 95%
       $dailyInspectionSummary->image_location = $imagePath . $imageFilename;

       // Simpan entri baru ke dalam basis data
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
        $dailyInspection->daily_inspection_summary_id = $newId;
        $dailyInspection->question_id = $item['question_id'];
        $dailyInspection->answer_id = $item['answer_id'];
        $dailyInspection->score_point = $score_point;
        $dailyInspection->created_at = strtotime($item['created_at']);
        $dailyInspection->updated_at = null;
        $dailyInspection->save();


        } else {
        // Jika area tidak ditemukan
        return response()->json(['message' => 'Invalid area data', 'id' => $newId], 400);
        }
        } else {
        // Jika pertanyaan atau jawaban tidak ditemukan
        return response()->json(['message' => 'Invalid question or answer data'], 400);
        }
        }
                

        return response()->json(['message' => "Daily Inspection Created!"], 200);
    }


}
