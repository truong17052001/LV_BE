<?php

use App\Http\Controllers\Client\ActivityController;
use App\Http\Controllers\Client\DiscountController;
use Illuminate\Support\Facades\Route;

Route::prefix('activity')->group(function () {
    Route::controller(ActivityController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'detail')->name('detail');
        Route::post('/add', 'create')->name('create');
        Route::put('/edit/{id}', 'edit')->name('edit');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
    
});;