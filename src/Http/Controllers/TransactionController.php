<?php
namespace Bryceandy\Laravel_Pesapal\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function details()
    {
        return view ('laravel_pespal::details');
    }

    public function payment(Request $request)
    {
        return $request->all();
    }
}
