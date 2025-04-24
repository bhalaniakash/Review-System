<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo;
use App\Models\Feedback;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Feedback_validate;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test',function(){
    return ["name"=>"akash","age"=>22]; 
});

Route::get('/demo',[Demo::class,'Hello']);
Route::get('/Dashboard',[DashboardController::class,'Api_index']);
Route::post('/feedback', [Demo::class, 'InsertData']);
Route::put('/Update', [Demo::class, 'UpdateData']);
Route::delete('Delete/{id}', [Demo::class, 'DeleteData']);
    