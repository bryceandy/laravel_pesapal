<?php

Route::group(['namespace' => 'Bryceandy\Laravel_Pesapal\Http\Controllers'], function(){

    Route::get('details', 'TransactionController@details');

    Route::post('iframe', 'TransactionController@payment');

    Route::get('callback', 'TransactionController@callback');

});

Route::get('ipn', function(){
    return view ('laravel_pesapal::ipn');
});


