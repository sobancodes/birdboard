<?php

use App\Http\Controllers\ProjectsController;
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

Route::controller(ProjectsController::class)->name('projects.')->middleware('auth')->group(function () {
    Route::get('/projects', 'index')->name('index');
    Route::post('/projects', 'store')->name('store');
    Route::get('/projects/{project}', 'show')->name('show');
});