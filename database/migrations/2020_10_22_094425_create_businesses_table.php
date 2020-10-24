<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('offender_id');
            $table->string('CompanyName')->nullable();
            $table->string('Owner')->nullable();
            $table->text('Activity')->nullable();
            $table->text('Address')->nullable();
            $table->integer('Country')->nullable();
            $table->geometry('longtitude')->nullable();
            $table->geometry('latitude')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Email')->nullable();
            $table->string('SocialNetwork')->nullable();
            $table->string('CompanyLogo')->nullable();
            $table->foreignId('user_id');
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
        Schema::dropIfExists('businesses');
    }
}
