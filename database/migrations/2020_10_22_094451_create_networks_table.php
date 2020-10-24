<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('MobName');
            $table->integer('NetworkType')->nullable();
            $table->text('NetworkActivity')->nullable();
            $table->text('MainAddress')->nullable();
            $table->integer('Country')->nullable();
            $table->integer('MemberNumber')->nullable();
            $table->integer('CrimeLevel')->nullable();
            $table->string('MobLogo');
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
        Schema::dropIfExists('networks');
    }
}
