<?php

Route::group(['namespace' => 'Bryceandy\Laravel_Pesapal\Http\Controllers'], function(){

    Route::post('pesapal/iframe', 'TransactionController@store');

    Route::get('callback', 'TransactionController@callback');

});



