<?php

namespace Bryceandy\Laravel_Pesapal\src\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function details()
    {
        return view ('Laravel_Pespal::details');
    }

    public function payment(Request $request)
    {
        return $request->all();
    }
}
