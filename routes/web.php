<?php
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyJobController;
use App\Http\Controllers\MyJobApplicationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('', fn() => to_route('jobs.index'));
Route::resource('jobs', JobController::class)->only(['index', 'show']);

Route::get('register', [AuthController::class, 'register'])->name('auth.register');

// Route to show the login form
Route::get('login', [AuthController::class, 'create'])->name('auth.create');

// Route to handle registration form submission
Route::post('register', [AuthController::class, 'signup'])->name('auth.signup');

// Route to handle login form submission
Route::post('login', [AuthController::class, 'store'])->name('auth.store');

// Route to handle logout
Route::post('logout', [AuthController::class, 'destroy'])->name('auth.logout');
Route::delete('auth', [AuthController::class, 'destroy'])
    ->name('auth.destroy');

    Route::middleware('auth')->group(function(){
        Route::resource('job.application', JobApplicationController::class )
        ->only(['create', 'store']);

        Route::resource('my-job-applications', MyJobApplicationController::class)
        ->only(['index', 'destroy']);

        Route::resource('employer', EmployerController::class)
        ->only(['create', 'store']);

        Route::middleware('employer')
        ->resource('my-jobs', MyJobController::class);
    });
