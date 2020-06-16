<?php

namespace Bryceandy\Laravel_Pesapal\Tests\Feature;

use Bryceandy\Laravel_Pesapal\Exceptions\ConfigurationUnavailableException;
use Bryceandy\Laravel_Pesapal\Payment;
use Bryceandy\Laravel_Pesapal\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

class GetIframeSourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function to_display_an_iframe_it_requires_consumer_key_and_secret()
    {
        $this->withoutExceptionHandling();

        $payment = factory(Payment::class)->make();

        $data = array_merge(['type' => Arr::random(['MERCHANT', 'ORDER'])], $payment->toArray());

        $this->expectException(ConfigurationUnavailableException::class);

        $this->post('pesapal/iframe', $data);
    }
}
