<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\AdminAuthController;
use \App\Http\Controllers\Admin\GiftBoxController;
use \App\Http\Controllers\Admin\BusinessRequestController;
use \App\Http\Controllers\Admin\WrappingController;
use \App\Http\Controllers\Admin\CategoryController;
use \App\Http\Controllers\Admin\StoreController;
use \App\Http\Controllers\Admin\AttributeController;
use \App\Http\Controllers\Admin\ProductController;
use \App\Http\Controllers\Admin\InventoryController;

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

    Route::group(["prefix" => "business-requests","middleware" => "auth:admin"],function (){
        Route::get("count",[BusinessRequestController::class,"CountNewRequest"]);
        Route::get("/",[BusinessRequestController::class,"index"]);
        Route::get("show/{id}",[BusinessRequestController::class,"show"]);
        Route::delete("delete/{id}",[BusinessRequestController::class,"delete"]);
    });

    Route::group(["prefix" => "wrapping","middleware" => "auth:admin"],function (){
        Route::get("/",[WrappingController::class,"index"]);
        Route::post("store",[WrappingController::class,"store"]);
        Route::get("show/{id}",[WrappingController::class,"show"]);
        Route::put("update/{id}",[WrappingController::class,"update"]);
        Route::put("change-status/{id}",[WrappingController::class,"ChangeStatus"]);
        Route::delete("delete/{id}",[WrappingController::class,"destroy"]);
    });

    Route::group(["prefix" => "categories","middleware" => "auth:admin"],function (){
        Route::get("/",[CategoryController::class,"index"]);
        Route::get("help-data",[CategoryController::class,"getHelpData"]);
        Route::post("store",[CategoryController::class,"store"]);
        Route::get("show/{id}",[CategoryController::class,"show"]);
        Route::put("update/{id}",[CategoryController::class,"update"]);
        Route::delete("delete/{id}",[CategoryController::class,"destroy"]);
    });

    Route::group(["prefix" => "stores","middleware" => "auth:admin"],function (){
        Route::get("/",[StoreController::class,"index"]);
        Route::post("store",[StoreController::class,"store"]);
        Route::get("show/{id}",[StoreController::class,"show"]);
        Route::put("update/{id}",[StoreController::class,"update"]);
        Route::put("change-password/{id}",[StoreController::class,"changePassword"]);
        Route::put("change-status/{id}",[StoreController::class,"ChangeStatus"]);
        Route::delete("delete/{id}",[StoreController::class,"destroy"]);
    });

    Route::group(["prefix" => "attribute-values","middleware" => "auth:admin"],function (){
        Route::get("index-attributes",[AttributeController::class,"indexAttributes"]);
        Route::post("store-attribute",[AttributeController::class,"storeAttribute"]);
        Route::get("show-attribute/{id}",[AttributeController::class,"showAttribute"]);
        Route::put("update-attribute/{id}",[AttributeController::class,"updateAttribute"]);
        Route::delete("delete-attribute/{id}",[AttributeController::class,"destroyAttribute"]);
        Route::post("store-value",[AttributeController::class,"storeValue"]);
        Route::put("update-value/{id}",[AttributeController::class,"updateValue"]);
        Route::delete("delete-value/{id}",[AttributeController::class,"destroyValue"]);
    });

    Route::group(["prefix" => "product","middleware" => "auth:admin"],function (){
        Route::get("help-data",[ProductController::class,"help_data"]);
        Route::get("/",[ProductController::class,"index"]);
        Route::post("store",[ProductController::class,"store"]);
        Route::get("show/{id}",[ProductController::class,"show"]);
        Route::get("edit/{id}",[ProductController::class,"edit"]);
        Route::put("change-status/{id}",[ProductController::class,"change_status"]);
        Route::group(["prefix" => "update"],function (){
            Route::put("details/{id}",[ProductController::class,"update_details"]);
            Route::delete("delete-image/{id}",[ProductController::class,"deleteImage"]);
            Route::post("add-images",[ProductController::class,"addImages"]);
            Route::put("pricing/{id}",[ProductController::class,"update_pricing"]);
            Route::put("pricing/{id}",[ProductController::class,"update_pricing"]);
            Route::put("inventory/{id}",[ProductController::class,"update_inventory"]);
        });
    });

    Route::group(["prefix" => "inventory","middleware" => "auth:admin"],function (){
        Route::get("/",[InventoryController::class,"index"]);
        Route::get("product-media",[InventoryController::class,"getProductMedia"]);
        Route::put("change-image/{id}",[InventoryController::class,"change_image"]);
        Route::put("change-available/{id}",[InventoryController::class,"change_available"]);
        Route::delete("delete-item/{id}",[InventoryController::class,"destroy"]);

    });
});
