<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesapalPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesapal_payments', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('phone_number')->nullable();
            $table->text('email')->nullable();

            $table->text('amount');
            $table->string('currency');

            //the reference and description will also be recorded on your PesaPal dashboard
            $table->string('reference');
            $table->text('description');

            // Payment status i.e PENDING or COMPLETED etc...
            $table->text('status')->nullable();

            //This is necessary when receiving IPN notifications
            $table->text('tracking_id')->nullable();

            // Methods include Mpesa, TigoPesa, Visa, Mastercard, American Express etc...
            $table->string('payment_method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesapal_payments');
    }
}
