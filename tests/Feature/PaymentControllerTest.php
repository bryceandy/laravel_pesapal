<?php

namespace Bryceandy\Laravel_Pesapal\Tests\Feature;

use Bryceandy\Laravel_Pesapal\Payment;
use Bryceandy\Laravel_Pesapal\Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    /** @test */
    public function required_attributes_should_be_validated_on_initiating_payments()
    {
        $payment = factory(Payment::class)->make([
            'amount' => null,
            'currency' => null,
            'description' => null,
            'type' => null,
            'reference' => null,
        ]);

        $this->json('POST','pesapal/iframe', $payment->toArray())
            ->assertStatus(422);
    }
}
