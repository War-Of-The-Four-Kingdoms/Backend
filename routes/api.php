<?php

use App\Http\Controllers\AuthenController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserAvatarController;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::post('refresh', [AuthenController::class, 'refreshToken']);
Route::post('gameStart', [GameController::class, 'storeGameData']);
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('details', [AuthenController::class, 'details']);
    Route::put('name/edit', [AuthenController::class, 'editUsername']);
    Route::get('revoke', function (Request $request) {
        $user = Auth::user()->token();
        $user->revoke();
        // DB::table('oauth_access_tokens')
        //     ->where('user_id', $request->user()->id)
        //     ->update([
        //         'revoked' => true
        //     ]);
        return response()->json('DONE');
    });
    Route::get('revoke/all', function (Request $request) {
        DB::table('oauth_access_tokens')
            ->where('user_id', $request->user()->id)
            ->update([
                'revoked' => true
            ]);
        return response()->json('DONE');
    });
});
Route::get('getRole', [GameController::class, 'getRoleList']);
Route::get('getCharacter', [GameController::class, 'getCharacterList']);
Route::post('storeGameData', [GameController::class, 'storeGameData']);
// Route::get('getRole',)
Route::get('drawCard', [GameController::class, 'drawCard']);
Route::put('dropCard', [GameController::class, 'dropCard']);
Route::get('openCard', [GameController::class, 'openCard']);
Route::put('updateCardInUse', [GameController::class, 'updateCardInUse']);
Route::get('getTop', [GameController::class, 'getTopCards']);
Route::put('setNewOrder', [GameController::class, 'setNewOrder']);
