<?php

namespace Bryceandy\Laravel_Pesapal\Tests\Unit;

use Bryceandy\Laravel_Pesapal\Payment;
use Bryceandy\Laravel_Pesapal\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_payment_can_be_created_with_a_factory()
    {
        factory(Payment::class)->create();

        $this->assertCount(1, Payment::all());
    }
}
