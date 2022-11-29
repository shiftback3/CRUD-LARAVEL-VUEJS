<?php


use App\Http\Controllers\RestfulController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'general'], function () {
    Route::get('{endpoint}', [RestfulController::class, 'index']);
    Route::post('{endpoint}', [RestfulController::class, 'store']);
    Route::get('{endpoint}/{id}', [RestfulController::class, 'show']);
    Route::put('{endpoint}/{id}', [RestfulController::class, 'update']);
    Route::get('{endpoint}/count', [RestfulController::class, 'count']);
    Route::delete('{endpoint}/{id}', [RestfulController::class, 'destroy']);
});