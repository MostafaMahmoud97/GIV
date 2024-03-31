<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\AdminAuthController;
use \App\Http\Controllers\Admin\GiftBoxController;

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
    Route::post("login",[AdminAuthController::class,"login"]);

    Route::group(["prefix" => "gift-box","middleware" => "auth:admin"],function (){
        Route::get("/",[GiftBoxController::class,"index"]);
        Route::post("store",[GiftBoxController::class,"store"]);
        Route::get("show/{id}",[GiftBoxController::class,"show"]);
        Route::put("update/{id}",[GiftBoxController::class,"update"]);
        Route::put("change-status/{id}",[GiftBoxController::class,"ChangeStatus"]);
        Route::delete("delete/{id}",[GiftBoxController::class,"destroy"]);
    });
});
