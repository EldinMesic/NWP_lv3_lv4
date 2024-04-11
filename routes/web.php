<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserBelongsToProject;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{project}', [ProjectController::class, 'show']
        )->middleware([EnsureUserBelongsToProject::class])->name('project.show');
    Route::put('/project/{project}', [ProjectController::class, 'update']
        )->middleware([EnsureUserBelongsToProject::class])->name('project.update');
});

