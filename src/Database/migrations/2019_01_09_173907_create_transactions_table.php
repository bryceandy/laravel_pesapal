<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('phone');
            $table->float('amount');
            $table->text('currency');
            $table->text('status')->nullable()->default('PLACED');
            $table->string('reference');
            $table->string('description');
            $table->string('tracking_id')->nullable()->default(null);
            $table->text('payment_method')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
