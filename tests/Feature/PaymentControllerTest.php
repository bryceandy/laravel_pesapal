<?php

namespace Bryceandy\Laravel_Pesapal\Tests\Feature;

use Bryceandy\Laravel_Pesapal\Payment;
use Bryceandy\Laravel_Pesapal\Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    /** @test */
    public function required_attributes_should_be_validated_when_posting_payments()
    {
        $payment = factory(Payment::class)->make([
            'amount' => null,
            'currency' => null,
            'description' => null,
            'type' => null,
            'reference' => null,
        ]);

        $response = $this->json('POST','pesapal/iframe', $payment->toArray());

        $response->assertStatus(422);

        $this->assertEquals($response['errors']["amount"][0], "The amount field is required.");

        $this->assertEquals($response['errors']["reference"][0], "The reference field is required.");
    }
}
