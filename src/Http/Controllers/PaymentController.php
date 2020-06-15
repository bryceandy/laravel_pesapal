<?php
namespace Bryceandy\Laravel_Pesapal\Http\Controllers;

use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use Bryceandy\Laravel_Pesapal\OAuth\CheckStatus;
use Bryceandy\Laravel_Pesapal\Payment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\View\View;

class PaymentController
{
    protected ValidationFactory $validation;

    /**
     * PaymentController constructor.
     *
     * @param ValidationFactory $validation
     */
    public function __construct(ValidationFactory $validation)
    {
        $this->validation = $validation;
    }

    /**
     * Stores a new payment, post it to pesapal &
     * displays the iframe with payment methods
     *
     * @param Request $request
     * @return Factory|View
     */
    public function store(Request $request)
    {
        $this->validation->make($request->all(), [
            'amount' => 'required|numeric',
            'currency' => 'required|in:TZS,KES,UGX,USD',
            'description' => 'required|min:5',
            'type' => 'required|in:MERCHANT',
            'reference' => 'required',
            'first_name' => 'sometimes|required|min:3',
            'last_name' => 'sometimes|required|min:3',
            'email' => 'required_without:phone_number|email',
            'phone_number' => 'required_without:email|numeric',
        ])->validate();

        Payment::create($request->all());

        $iframe_src = Pesapal::getIframeSource($request);

        return view ('laravel_pesapal::iframe', compact('iframe_src'));
    }

    public function callback()
    {
        $checkStatus = new CheckStatus();

        $pesapalMerchantReference = isset($_GET['pesapal_merchant_reference']) ?
            $_GET['pesapal_merchant_reference'] : null;

        $pesapalTrackingId = isset($_GET['pesapal_transaction_tracking_id']) ?
            $_GET['pesapal_transaction_tracking_id'] : null;

        //obtaining the payment status after a payment
        $status = $checkStatus->byTrackingIdAndMerchantRef($pesapalMerchantReference, $pesapalTrackingId);

        //display the reference and payment status on the callback page
        return view ('laravel_pesapal::callback_example', compact('pesapalMerchantReference', 'status'));
    }
}
