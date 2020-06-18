<?php

namespace Bryceandy\Laravel_Pesapal\Tests\Feature;

use Bryceandy\Laravel_Pesapal\Payment;
use Bryceandy\Laravel_Pesapal\Tests\TestCase;
use Illuminate\Foundation\Application;

class PaymentControllerTest extends TestCase
{
    /**
     * Mocked Config
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('pesapal.consumer_key', 'key');
        $app['config']->set('pesapal.consumer_secret', 'secret');
        $app['config']->set('pesapal.callback_url', 'http://testurl.com');
    }

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
