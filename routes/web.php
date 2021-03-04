<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImagesController;

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

Route::redirect('/', '/dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
  Route::get('/dashboard',[ImagesController::class, 'index'])->name('dashboard');
  Route::get('/image',[ImagesController::class, 'add']);
  Route::post('/image',[ImagesController::class, 'create']);
  Route::get('/image/{image}', [ImagesController::class, 'view']);
  Route::get('/image/{image}/edit', [ImagesController::class, 'edit']);
  Route::post('/image/{image}', [ImagesController::class, 'update']);
});