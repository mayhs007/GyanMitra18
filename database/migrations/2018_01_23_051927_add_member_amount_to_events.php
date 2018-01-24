<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemberAmountToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('events', function($table)
        {
            $table->integer('pg_amount')->default('0')->after('amount');
            $table->integer('sae_amount')->default('0')->after('pg_amount');
            $table->integer('ie_amount')->default('0')->after('sae_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('events', function(Blueprint $table){
        $table->dropColumn('sae_amount');
        $table->dropColumn('ie_amount');
    });
    }
}
