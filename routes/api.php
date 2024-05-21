<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\BusinessRequestController;
use \App\Http\Controllers\Api\AuthUserController;

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

Route::group(["middleware" => "localRequest"],function (){
    Route::post("business-request/store",[BusinessRequestController::class,"store"]);

    Route::group(["prefix" => "auth"],function (){
        Route::get("help-data",[AuthUserController::class,"helpData"]);
        Route::post("sign-up",[AuthUserController::class,"register"]);
        Route::post("sign-in",[AuthUserController::class,"login"]);
        Route::get("call-back-verify",[AuthUserController::class,"verifyEmail"]);
        Route::post("resend-verify-email",[AuthUserController::class,"resendVerifyEmail"])->middleware("auth:api");

        Route::post("forgot-password",[AuthUserController::class,"forgot_password"]);
        Route::get("callback-reset-password",[AuthUserController::class,"callback_reset_password"]);
        Route::post("reset-password",[AuthUserController::class,"reset_password"]);
    });
});
