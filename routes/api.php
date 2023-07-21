<?php 
use App\Http\Controllers\app\AnswerController;
use App\Http\Controllers\app\AreaController;
use App\Http\Controllers\app\InspectionController;
use App\Http\Controllers\app\QuestionController;
use App\Http\Controllers\app\CompanyController;
use App\Http\Controllers\auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/question', [QuestionController::class, 'apkIndex']);
Route::post('apklogin', [LoginController::class, 'apklogin']);
Route::get('/question/{area_id}', [QuestionController::class, 'questionIndex']);
Route::get('/area', [AreaController::class, 'areaIndex']);
Route::get('/answer', [AnswerController::class, 'allAnswerIndex']);
Route::get('/answer/{question_id}', [AnswerController::class, 'answerIndex']);
Route::get('/daily+inspection+summary', [InspectionController::class, 'inspectionIndex']);
Route::post('/store-inspections', [InspectionController::class, 'storeInspection']);
Route::post('/store-company', [CompanyController::class, 'apiStoreCompany']);

// Route::get('/question-show', [QuestionController::class, 'showQuestionArea'])->name('question.show');
