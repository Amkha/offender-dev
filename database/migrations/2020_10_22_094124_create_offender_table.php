<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffenderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offender', function (Blueprint $table) {
            $table->increments('id');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Gender');
            $table->integer('Age');
            $table->string('IDCardNumber')->nullable();
            $table->string('Occupation')->nullable();
            $table->string('Nationality')->nullable();
            $table->string('Address')->nullable();
            $table->integer('Province')->nullable();
            $table->integer('District')->nullable();
            $table->integer('Village')->nullable();
            $table->integer('MainBusiness')->nullable();
            $table->integer('MainNetwork')->nullable();
            $table->string('Photo')->nullable();
            $table->string('Action')->nullable();
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('offender');
    }
}
