<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Bryceandy\Laravel_Pesapal\Http\Controllers'], function(){

    Route::post('pesapal/iframe', 'PaymentController@store')
        ->name('payment.store')
        ->middleware('config');

    Route::get('pesapal/iframe', 'PaymentController@store')
        ->name('payment.store.get')
        ->middleware('config');
});
