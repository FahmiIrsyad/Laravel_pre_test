<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;

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

// Default route to display a welcome view
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (login, register, password reset, etc.)
Auth::routes();

// Routes requiring authentication
Route::get('/', [NewsletterController::class, 'showAll'])->name('showAll');
Route::get('/newsletters/show-all', [NewsletterController::class, 'showAll'])->name('newsletters.showAll');

// Routes requiring authentication
Route::middleware(['auth'])->group(function () {
    Route::resource('newsletters', NewsletterController::class);
    Route::put('newsletters/recover/{id}', [NewsletterController::class, 'recover'])->name('newsletters.recover');
});


