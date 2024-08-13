<?php

use App\Http\Controllers\Client\DiscountController;
use Illuminate\Support\Facades\Route;

Route::prefix('discount')->group(function () {
    Route::controller(DiscountController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'detail')->name('detail');
        Route::get('/apply/{ma}', 'applyDiscount')->name('applyDiscount');
        Route::post('/add', 'create')->name('create');
        Route::put('/edit/{id}', 'edit')->name('edit');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
    
});;