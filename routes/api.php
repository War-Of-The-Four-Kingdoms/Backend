<?php

use App\Http\Controllers\AuthenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthenController::class, 'login']);
Route::post('register', [AuthenController::class, 'register']);
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', [AuthenController::class, 'details']);
    Route::get('/token/revoke', function (Request $request) {
        DB::table('oauth_access_tokens')
            ->where('user_id', $request->user()->id)
            ->update([
                'revoked' => true
            ]);
        return response()->json('DONE');
    });
});
Route::get('getRole',)
