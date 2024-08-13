<?php

use App\Http\Controllers\Client\PaymentController;
use Illuminate\Support\Facades\Route;

Route::prefix('payment')->group(function () {
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/momo', 'momo_payment')->name('momo_payment');
        Route::post('/momo/callback', 'momoCallback')->name('momoCallback');
        Route::get('/{id}', 'detail')->name('detail');
        Route::post('/add', 'create')->name('create');
        Route::put('/edit/{id}', 'edit')->name('edit');
        Route::put('/paid/{id}', 'paid')->name('paid');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::post('/email', 'sendThankYouEmail')->name('sendThankYouEmail');
    });
});;