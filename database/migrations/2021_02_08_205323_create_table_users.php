<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsers extends Migration
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

            $table->string('api_token');
            $table->string('phone');
            $table->string('name')->nullable();
            $table->string('username');
            $table->string('password');
            $table->unsignedInteger('role'); // 0 -> patient, 1 -> doctor
            $table->unsignedInteger('specialty_id')->nullable();
            $table->unsignedInteger('nezam')->nullable();
            $table->boolean('online_pay')->nullable();
            $table->unsignedInteger('experience_years')->nullable();
            $table->text('address')->nullable();
            $table->string('week_days')->nullable();
            $table->string('image')->nullable();

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
