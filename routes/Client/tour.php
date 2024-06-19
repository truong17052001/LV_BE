<?php

use App\Http\Controllers\Client\TourController;
use Illuminate\Support\Facades\Route;

Route::prefix('tour')->group(function () {
    Route::controller(TourController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'detail')->name('detail');
        Route::post('/add', 'create')->name('create');
        Route::put('/edit/{id}', 'edit')->name('edit');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
    
});;