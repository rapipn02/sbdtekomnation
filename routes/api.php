<?php

use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/test-token', function (Request $request) {
    return response()->json([
        'message' => 'Token berfungsi dengan baik!',
        'user' => $request->user(),
    ]);
});

Route::post('/midtrans-callback',[MemberController::class,'callback']);