<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('college_id')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('type', ['student', 'admin']);
            $table->string('level_of_study')->default('admin');
            $table->boolean('Present')->default(false);
            $table->boolean('confirmation')->default(false);
            $table->boolean('Accomodation_Confirmation')->default(false);
            $table->rememberToken();
            $table->boolean('activated')->default(false);
            $table->string('activation_code')->nullable();     
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
        Schema::dropIfExists('users');
    }
}
