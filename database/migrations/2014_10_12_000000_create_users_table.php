<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('gender')->nullable();  //0=male ; 1=Female
            $table->foreignId('city')->nullable();
            $table->foreignId('work')->nullable();
            $table->string('phone')->unique();
            $table->string('password');
            $table->integer('hour')->nullable();
            $table->unsignedTinyInteger('coffee_cat')->default(0); // 0 = coffee , 1 = Normal dinner , 2=Fancy dinner
            $table->unsignedTinyInteger('status')->default(0); // 0 = available , 1 = unavailable
            $table->unsignedTinyInteger('role')->default(0); //  0=admin , 1=user
            $table->string('param1')->nullable();
            $table->string('param2')->nullable();
            $table->string('param3')->nullable();
            $table->longText('remember_token')->nullable();
            $table->longText('fcm_token')->nullable();
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
