<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Area;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AnswerController extends Controller
{
    //
        public function showAnswerArea(){
            $areas = Area::all();

            return view('answer.show', compact('areas'));
        }

        public function showListQuestion(Area $area)
        {
            $questions = Question::where('area_id', '=', $area->id)->paginate(10); // Mengambil 10 pertanyaan per halaman

            return view('answer.list', compact('questions'));
        }

        public function detailAnswer(Question $question){
            $answers = Answer::where('question_id', '=', $question->id)->get();

            return view('answer.detail', ['question' => $question, 'answers' => $answers]);
        }
        public function getCreateForm(Question $question){
            // $areas = Area::all();

            return view('answer.create', ['question' => $question]);
        }

        public function createAnswer(Request $request, Question $question)
        {
        // Validasi data input

        $validatedData = $request->validate([
        'text' => 'required',
        'point' => 'required|integer',
        // 'area_id' => 'required|exists:areas,id',
        ]);

        // $question_id = Question::where('id', '=', $question->id)->get();
        // $status = $request->has('activate_question') ? 'active' : 'non-nactive';
        // Buat pertanyaan baru dengan data yang valid
        $answer = new Answer;
        $answer->answer = $validatedData['text'];
        $answer->point = $validatedData['point'];
        $answer->question_id = $question->id;
        $answer->save();

        // Redirect atau melakukan tindakan lainnya sesuai kebutuhan Anda
        return redirect()->back()->with('success', 'Pertanyaan berhasil dibuat.');
        }
        public function answerIndex($question_id){
        $answers = Answer::where('question_id', '=', $question_id)->get();
        return response()->json($answers);
        }
        public function allAnswerIndex(){
        $answers = Answer::all();
        return response()->json($answers);
        }
}
