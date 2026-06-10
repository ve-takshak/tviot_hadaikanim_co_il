<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\LawsuitController;
use App\Http\Controllers\AppraiserController;
use Takshak\Adash\Http\Middleware\GatesMiddleware;
use App\Http\Controllers\InsuranceCompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login')->name('root');
Route::get('client/login', [UserController::class, 'clientLogin'])->name('client.login');
Route::post('client/login', [UserController::class, 'clientLoginDo'])->name('client.logindo');
Route::middleware(['auth',  GatesMiddleware::class])->group(function () {
    // Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
    // Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('comment/add', [LawsuitController::class, 'addComment'])->name('comment.add');
    Route::delete('comment/delete/{comment}', [LawsuitController::class, 'deleteComment'])->name('comment.delete');
    Route::post('document/add', [LawsuitController::class, 'addDocument'])->name('document.add');
    Route::delete('document/delete/{document}', [LawsuitController::class, 'deleteDocument'])->name('document.delete');
    Route::post('insurance-claims/status/{insurance_claim}', [LawsuitController::class, 'changeStatus'])->name('insurance-claims.status');
    
    Route::post('csv', [LawsuitController::class, 'importCsv'])->name('importCsv.store');
    Route::get('csv', [LawsuitController::class, 'importCsvform'])->name('importCsv.form');

    Route::post('/toggle-dark-mode', [UserController::class, 'toggleDarkMode'])->name('toggle-mode');

    Route::resource('insurance-companies', InsuranceCompanyController::class);
    Route::resource('appraiser', AppraiserController::class);
    Route::resource('insurance-claims', LawsuitController::class);
    Route::get('calendar', [LawsuitController::class, 'calendarIndex'])->name('calendar');

Route::post('exportclaims', [LawsuitController::class, 'exportClaims'])->name('insurance-claims.export');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
