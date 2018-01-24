<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccomodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomodations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('acc_transaction_id')->nullable();
            $table->string('acc_mode_of_payment');
            $table->string('acc_file_name')->nullable();
            $table->enum('acc_payment_status', ['paid', 'notpaid'])->nullable();
            $table->enum('acc_status', ['ack', 'nack'])->nullable();
            $table->integer('user_id');
        
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
        Schema::dropIfExists('accomodations');
    }
}
