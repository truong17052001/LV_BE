<?php

use App\Http\Controllers\Client\DateController;
use Illuminate\Support\Facades\Route;

Route::prefix('date')->group(function () {
    Route::controller(DateController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/add', 'create')->name('create');
        Route::put('/edit/{id}', 'edit')->name('edit');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
    
});;