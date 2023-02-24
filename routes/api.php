<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AuthController;
use App\Http\Resources\NotesResource;
use App\Models\Note;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes

// Public routes
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);



// Protected routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/user', [AuthController::class, 'user'])->name('users.index');
    Route::get('/notes',[NoteController::class, 'index']);
    Route::get('/notes/{note}',[NoteController::class, 'show']);
    Route::get('/notes/search/{title}',[NoteController::class, 'search']);
    Route::put('/notes/{note}',[NoteController::class, 'update']);
   
    Route::delete('/notes/{note}',[NoteController::class, 'destroy']);
    Route::post('/notes',[NoteController::class, 'store']);    
    Route::delete('/notes',[NoteController::class, 'destroyMultiple']);

    Route::post('/logout',[AuthController::class, 'logout']);
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});