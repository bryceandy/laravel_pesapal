<?php

namespace Bryceandy\Laravel_Pesapal;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'pesapal_payments';

    protected $guarded = [];

    /**
     * Modify payment
     *
     * @param $transaction
     * @return mixed
     */
    public static function modify($transaction)
    {
        // Status will always detect a change and send notifications by IPN
        $payment = Payment::whereReference($transaction['pesapal_merchant_reference'])->first();

        return $payment->update([
            'status' => $transaction['status'],
            'payment_method' => $transaction['payment_method'],
            'tracking_id' => $transaction['pesapal_transaction_tracking_id'],
        ]);
    }
}
