<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Area;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    //
    public $timestamps = false;
    public function showQuestionArea(){
        $areas = Area::all();

        return view('question.show', compact('areas'));
    }

    public function showListQuestion(Area $area)
    {
        $questions = Question::where('area_id', '=', $area->id)->get(); // Mengambil 10 pertanyaan per halaman

        return view('question.list', ['questions' => $questions, 'area' => $area]);
    }

    public function createQuestion(Request $request)
    {
    // Validasi data input
    
        $validatedData = $request->validate([
        'question' => 'required',
        'weight' => 'required|integer',
        'area_id' => 'required|exists:areas,id',
        ]);

        $status = $request->has('activate_question') ? 'active' : 'non-nactive';
        // Buat pertanyaan baru dengan data yang valid
        $question = new Question;
        $question->question = $validatedData['question'];
        $question->weight = $validatedData['weight'];
        $question->area_id = $validatedData['area_id'];
        $question->status = $status; // Mengatur status default menjadi 'non-active'
        $question->numbering = 0;
        $question->save();

        // Redirect atau melakukan tindakan lainnya sesuai kebutuhan Anda
        return redirect()->route('question.list', $validatedData['area_id'])->with('success', 'Question Created Successfully!');
    }

    public function getCreateForm(Area $area){
         $areas = Area::all();

        return view('question.create', compact('areas'));
    }

public function updateStatus(Request $request, Question $question)
{
$status = $question->status == 'active' ? 'non-active' : 'active';
$question->status = $status;

if ($question->status === 'non-active') {
// Mengubah nomor pertanyaan setelah question yang di-deactivate
$area = $question->areas; // Mendapatkan area pertanyaan
$questions = $area->questions()
->where('status', 'active')
->where('numbering', '>', $question->numbering) // Filter pertanyaan dengan nomor pertanyaan lebih besar dari pertanyaanyang di-deactivate
->orderBy('numbering')
->get(); // Mendapatkan pertanyaan-pertanyaan aktif terkait area

foreach ($questions as $q) {
$q->numbering -= 1; // Mengurangi nomor pertanyaan
$q->save(); // Menyimpan perubahan pada pertanyaan
}
} elseif ($question->status === 'active') {
// Mengubah nomor pertanyaan menjadi nomor terakhir
$area = $question->areas; // Mendapatkan area pertanyaan
$lastNumberingQuestion = $area->questions()->where('status', 'active')->max('numbering'); // Mendapatkan nomorpertanyaan terakhir dari pertanyaan-pertanyaan aktif terkait area

$question->numbering = $lastNumberingQuestion + 1; // Mengatur nomor pertanyaan baru
}

if ($question->status === 'non-active') {
$question->numbering = 0; // Set nomor pertanyaan menjadi 0 jika status menjadi non-active
}

$question->save(); // Menyimpan perubahan status dan nomor pertanyaan

return redirect()->back()->with('success', 'Status berhasil diubah.');
}






    public function previewQuestion(Area $area)
    {
        $questions = $area->questions()
        ->where('status', 'active')
        ->orderBy('numbering', 'asc')
        ->get();

        $questionIds = $questions->pluck('id');

        $answers = Answer::whereIn('question_id', $questionIds)->get();

        return view('question.preview', ['questions' => $questions, 'answers' => $answers, 'area' => $area]);
    }

        public function numberingQuestion(Area $area)
        {
        $questions = $area->questions()
        ->where('status', 'active')
        ->get();

        $total_question = 1;
        $questionIds = $questions->pluck('id');

        $answers = Answer::whereIn('question_id', $questionIds)->get();

        return view('question.numbering', ['questions' => $questions, 'answers' => $answers, 'area' => $area, 'total_question' => $total_question]);
        }

        public function updateQuestionNumbering(Request $request, Area $area)
        {
            $questions = $request->input('questions'); // Menangkap data pertanyaan dari form
            // Melakukan iterasi pada setiap pertanyaan
            foreach ($questions as $index => $questionData) {
                $question = Question::find($questionData['id']); // Mengambil pertanyaan dari database berdasarkan ID
                $question->numbering = ($index + 1); // Mengubah numbering pada pertanyaan
                $question->save(); // Menyimpan perubahan pada pertanyaan
            }

            // Redireksi ke halaman yang sesuai
            return redirect()->route('question.preview', ['area' => $area->id])->with('success', 'Numbering successfully
            updated');

        }

        public function apkIndex(){
            $questions = Question::where('status', '=', 'active')->get();
            return response()->json($questions);
        }
        public function questionIndex($area_id){
            $questions = Question::where('area_id', $area_id)
            ->where('status', 'active')
            ->get();
            return response()->json($questions);
        }


public function getDetailQuestion(Question $question){
    $answers = Answer::where('question_id', $question->id);
    $area = Area::where('id', $question->area_id)->first();
    return view('question.detail', [
        'question' => $question,
        'answers'=> $answers,
        'area' => $area,
    ]);
}

}
