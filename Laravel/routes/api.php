<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Models\UserSetting;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user-theme', function (Request $request){
        $settings = UserSetting::where('user_id', $request->user_id)->first();
        return response()->json(['theme' => $settings], 201);
    });

Route::middleware('auth:sanctum')->post('/user-theme', function (Request $request) {
    $request->validate([
        'theme' => 'required|in:light,dark',
    ]);
    $user = $request->user();
    $setting = $user->settings;
    if (!$setting) {
        $setting = new \App\Models\UserSetting();
        $setting->user_id = $user->id;
    }
    $setting->theme = $request->theme;
    $setting->save();
    return response()->json(['message' => 'Theme updated']);
});
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});