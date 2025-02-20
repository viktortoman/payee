<?php

use App\Http\Controllers\API\InterestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('interest')->name('interest.')->group(function () {
    Route::get('/', [InterestController::class, 'index'])->name('index');
    Route::get('/get-min-max-dates', [InterestController::class, 'getMinAndMaxDates'])->name('get-min-max-dates');
    Route::post('/calculate', [InterestController::class, 'calculate'])->name('calculate');
});
