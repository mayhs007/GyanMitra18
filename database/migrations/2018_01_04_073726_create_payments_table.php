<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id')->nullable();
            $table->string('mode_of_payment')->nullable();
            $table->string('file_name')->nullable();
            $table->enum('payment_status', ['paid', 'notpaid'])->nullable();
            $table->enum('status', ['ack', 'nack'])->nullable();
            $table->integer('user_id');
            $table->integer('paid_by')->nullable();
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
        Schema::dropIfExists('Payments');
    }
}
