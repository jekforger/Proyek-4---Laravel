<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ExerciseController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('sign-up', [AuthController::class, 'signUp']);
Route::post('sign-in', [AuthController::class, 'signIn']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    //User
    Route::get('user', [UserController::class, 'user']);
    Route::post('bmi', [UserController::class, 'bmi']);
    
    //Exercise
    Route::get('exercises', [ExerciseController::class, 'exercises']);

    //Auth
    Route::post('sign-out', [AuthController::class, 'signOut']);
});
