<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('department_id');    
            $table->string('title');            
            $table->text('description');
            $table->string('image_name')->nullable();                        
            $table->text('rules');
            $table->string('resource_person')->default('none');                                    
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('prelims')->nullable();
            $table->time('round1')->nullable();
            $table->time('round2')->nullable();
            $table->time('finals')->nullable();
            $table->integer('min_members');
            $table->integer('max_members');           
            $table->integer('max_limit');
            $table->integer('pg_amount')->default('0');;
            $table->integer('amount');
            $table->string('contact_email');
            $table->string('venue');
            $table->boolean('allow_gender_mixing')->default(false);            
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
        Schema::dropIfExists('events');
    }
}
