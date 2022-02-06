<?php

use App\Http\Controllers\Grades\GradesController;
use App\Http\Controllers\Classroom\ClassroomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // ======================== Home ========================
        Route::get('/', function () {
            return view('welcome');
        });

        Route::group(['middleware' => ['auth']], function () {
                // ======================== Dashboard ========================
                Route::get('/dashboard', function () {
                    return view('dashboard');
                })->name('dashboard');

                // ======================== Grades ========================
                Route::resource('grades', GradesController::class);

                // ======================== Classrooms ========================
                Route::resource('classrooms', ClassroomController::class);
                Route::post('deleteAll', [ClassroomController::class, 'deleteAll'])
                    ->name('deleteAll');
                Route::post('filterByGrade', [ClassroomController::class, 'filterByGrade'])
                    ->name('filterByGrade');
            });

        require __DIR__ . '/auth.php';
    }
);
