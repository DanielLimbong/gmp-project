<?php

use App\Http\Controllers\app\QuestionController;
use App\Http\Controllers\app\AnswerController;
use App\Http\Controllers\app\AreaController;
use App\Http\Controllers\app\CompanyController;
use App\Http\Controllers\app\InspectionController;
use App\Http\Controllers\app\IssueController;
use App\Http\Controllers\app\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\ProfilController;
use App\Http\Controllers\DashboardController;
use Haruncpi\LaravelIdGenerator\IdGenerator;



// Middleware 'auth' Laravel
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', function () {
    return view('welcome');
    });
// Dashboard
Route::get('/welcome', [DashboardController::class, 'showDashboard'])->name('dashboard');

// question
Route::get('/question-show', [QuestionController::class, 'showQuestionArea'])->name('question.show');
Route::get('/question-create', [QuestionController::class, 'getCreateForm'])->name('question.create');
Route::get('/question-create', [QuestionController::class, 'getCreateForm'])->name('question.create');
Route::post('/question-store', [QuestionController::class, 'createQuestion'])->name('question.store');
Route::get('/question-list/{area}', [QuestionController::class, 'showListQuestion'])->name('question.list');
Route::get('/question-preview/{area}', [QuestionController::class, 'previewQuestion'])->name('question.preview');
Route::get('/question-numbering/{area}', [QuestionController::class, 'numberingQuestion'])->name('question.numbering');
Route::post('/question-numbering/update/{area}', [QuestionController::class,'updateQuestionNumbering'])->name('question.numberingUpdate');
Route::put('/questions/{question}', [QuestionController::class, 'updateStatus'])->name('question.update');

// answer
Route::get('/answer', [AnswerController::class, 'showAnswerArea'])->name('answer.show');
Route::get('/question-answer-list/{area}', [AnswerController::class, 'showListQuestion'])->name('answer.list');
Route::get('/answer-detail/{question}', [AnswerController::class, 'detailAnswer'])->name('answer.detail');
Route::get('/answer-create/{question}', [AnswerController::class, 'getCreateForm'])->name('answer.create');
Route::post('/answer-store/{question}', [AnswerController::class, 'createAnswer'])->name('answer.store');

// inpsection
Route::get('/daily-inspection/{area}', [InspectionController::class, 'showInspection'])->name('inspection.show');
Route::get('/inspection-detail/{dailyInspectionSummary}', [InspectionController::class,'inspectionDetail'])->name('inspection.detail');
Route::get('/inspection-area', [InspectionController::class, 'inspectionArea'])->name('inspection.area');
Route::get('/inspection-update-point', [InspectionController::class,'getUpdatePoint'])->name('inspection.update-point');
Route::post('/inspection-update-status/{dailyInspectionSummary}', [InspectionController::class,'updateStatus'])->name('update.status');
Route::post('/inspection-update-point/{dailyInspectionSummary}', [InspectionController::class,'updatePoint'])->name('update.point');

// user
Route::get('/user-details', [UserController::class, 'getUserList'])->name('user.detail');
Route::get('/area', [UserController::class, 'getAreaList'])->name('user.area');
Route::get('/create-user', [UserController::class, 'getCreateUser'])->name('user.create');
Route::get('/view-user/{user}', [UserController::class, 'ViewUser'])->name('user.view');
Route::get('/edit-user/{user}', [UserController::class, 'getEditUser'])->name('user.edit');
Route::post('/edit-user/{user}', [UserController::class, 'editUser'])->name('user.put');
Route::post('/store-user', [UserController::class, 'storeUser'])->name('user.store');
Route::post('/delete-user/{user}', [UserController::class, 'deleteUser'])->name('user.delete');
Route::post('/activate-user/{user}', [UserController::class, 'activateUser'])->name('user.activate');

// area
Route::get('/create-area', [AreaController::class, 'getCreateArea'])->name('area.create');
Route::post('/store-area', [AreaController::class, 'storeArea'])->name('area.store');
Route::get('/edit-area/{area}', [AreaController::class, 'getEditArea'])->name('area.edit');
Route::post('/post-area/{area}', [AreaController::class, 'editArea'])->name('area.post');

// company
Route::get('list-company', [CompanyController::class, 'getCompany'])->name('company.list');
Route::get('create-company', [CompanyController::class, 'createCompany'])->name('company.create');
Route::get('edit-company/{company}', [CompanyController::class, 'getEditCompany'])->name('company.edit');
Route::post('edit-company/{company}', [CompanyController::class, 'editCompany'])->name('company.put');
Route::post('store-company', [CompanyController::class, 'storeCompany'])->name('company.store');
Route::post('/delete-company/{company}', [CompanyController::class, 'deleteCompany'])->name('company.delete');
Route::post('/activate-company/{company}', [CompanyController::class, 'activateCompany'])->name('company.activate');
});

// Auth routes (without 'auth' middleware)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/profile', [ProfilController::class, 'showProfile'])->name('auth.profile');
Route::get('/change-password', [ProfilController::class, 'getChangePassword'])->name('change.password');
Route::post('/change-password', [ProfilController::class, 'changePassword'])->name('store.password');

// issue
Route::get('/list-area-issue', [IssueController::class, 'showListArea'])->name('issue.area');
Route::get('/list-inspection-issue/{area}', [IssueController::class, 'showInspectionIssue'])->name('issue.inspection');
Route::get('/detail-issue/{dailyInspectionSummary}', [IssueController::class, 'showIssues'])->name('issue.detail');
Route::get('/show-issue/{issue}', [IssueController::class, 'issueShow'])->name('issue.show');
Route::post('/close-issue/{issue}', [IssueController::class, 'closeIssue'])->name('issue.close');
