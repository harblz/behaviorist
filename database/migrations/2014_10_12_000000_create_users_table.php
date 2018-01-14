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
            $table->string('status')->default('active');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('user_type')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->dateTime('dob')->nullable();
            $table->string('contact_phone_work')->nullable();
            $table->string('contact_phone_home')->nullable();
            $table->string('contact_phone_cell')->nullable();
            $table->string('preferred_contact')->nullable();
            $table->text('notes')->nullable();
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('language')->default('English');
            $table->rememberToken();
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
