<?php

namespace Bryceandy\Laravel_Pesapal\Tests\Unit;

use Bryceandy\Laravel_Pesapal\Payment;
use Bryceandy\Laravel_Pesapal\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    private array $transaction;

    /**
     * @var Collection|Model
     */
    private $payment;

    protected function setUp(): void
    {
        parent::setUp();

        $reference = Str::random(7);

        $this->payment = factory(Payment::class)->create([
            'reference' => $reference,
        ]);

        $this->transaction = [
            'pesapal_merchant_reference' =>$reference,
            'status' => Arr::random(['PENDING', 'COMPLETED', 'FAILED', 'CANCELLED']),
            'payment_method' => Arr::random(['MPESA', 'VISA', 'MASTERCARD', 'TIGOPESA']),
            'pesapal_transaction_tracking_id' => Str::random(),
        ];
    }

    /** @test */
    public function a_payment_can_be_created_with_a_factory()
    {
        $this->payment;

        $this->assertCount(1, Payment::all());
    }

    /** @test */
    public function payments_can_be_updated()
    {
        $payment = $this->payment;

        $payment->modify($this->transaction);

        $this->assertDatabaseHas('pesapal_payments', [
            'id' => $payment->id,
            'status' => $this->transaction['status'],
            'tracking_id' => $this->transaction['pesapal_transaction_tracking_id'],
        ]);
    }

    /** @test */
    public function payment_amounts_should_be_formatted_and_in_two_decimal_points()
    {
        $payment = factory(Payment::class)->create([
            'amount' => 12345,
        ]);

        $this->assertEquals("12,345.00", $payment->amount);
    }
}
