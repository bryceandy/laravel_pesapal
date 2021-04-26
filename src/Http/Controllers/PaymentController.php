<?php
namespace Bryceandy\Laravel_Pesapal\Http\Controllers;

use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use Bryceandy\Laravel_Pesapal\Payment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;
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
     * Stores a new payment, post it to Pesapal &
     * displays the iframe with payment methods
     *
     * @param Request $request
     *
     * @return Factory|View
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validation->make($request->all(), [
            'amount' => 'required|numeric',
            'currency' => 'required|in:TZS,KES,UGX,USD',
            'description' => 'required|min:5',
            'type' => 'required|in:MERCHANT,ORDER',
            'reference' => 'required',
            'first_name' => 'sometimes|required|min:3',
            'last_name' => 'sometimes|required|min:3',
            'email' => 'required_without:phone_number|email',
            'phone_number' => 'required_without:email|numeric',
        ])->validate();

        Payment::create($request->except(['type', '_token']));

        $iframe_src = Pesapal::getIframeSource($request->all());

        return view ('laravel_pesapal::iframe', compact('iframe_src'));
    }
}
