<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('title')->default("Pet Society");
            $table->string('en_title')->default("Pet Society");
            $table->string('content')->nullable();
            $table->string('en_content')->nullable();
            $table->unsignedTinyInteger('type')->default(0); // 1=public , 0=private
            $table->unsignedTinyInteger('status')->default(0); // 0=sent , 1=seen,


            $table->string('param1')->nullable();
            $table->string('param2')->nullable();
            $table->string('param3')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
