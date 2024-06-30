<?php

use App\Http\Controllers\Client\TourGuiderController;
use Illuminate\Support\Facades\Route;

Route::prefix('guider')->group(function () {
    Route::controller(TourGuiderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'detail')->name('detail');
        Route::post('/add', 'create')->name('create');
        Route::put('/edit/{id}', 'edit')->name('edit');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
    
});;