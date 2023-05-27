<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectTaskController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::controller(ProjectsController::class)->prefix('projects')->name('projects.')->middleware('auth')->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('', 'store')->name('store');
    Route::get('{project}', 'show')->name('show');
    Route::patch('{project}', 'update')->name('update');
});

Route::controller(ProjectTaskController::class)->prefix('projects')->name('projects.')->middleware('auth')->group(function () {
    Route::post('{project}/tasks', 'store');
    Route::patch('{project}/tasks/{task}', 'update');
});
