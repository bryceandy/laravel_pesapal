<?php

Route::get('details', 'TransactionController@details');

Route::post('iframe', 'TransactionController@payment');
