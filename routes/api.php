<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;


use App\Http\Controllers\UserController;


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

// By the way, thank you for your attention to me as a candidate,
// despite my terrible first attempt you gave me a chance to improve my code, I appreciate it.
// Unfortunately, I have never built Laravel's API, so it was my first experience and even if you will not proceed
// recruitment process with me, I found committing this test task very useful for my professional career, since I learnt a lot of new staff.
// Have a nice day!

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', UserController::class);
