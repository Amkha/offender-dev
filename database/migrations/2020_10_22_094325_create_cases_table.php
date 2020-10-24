<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('offender_id');
            $table->date('DetectedDate');
            $table->string('Type')->nullable();
            $table->integer('ItemNumber')->nullable();
            $table->integer('Unit')->nullable();
            $table->decimal('Amount', 8, 2)->nullable();
            $table->text('CaseDescription')->nullable();
            $table->text('Evidence')->nullable();
            $table->integer('Status')->nullable();
            $table->integer('Location')->nullable();
            $table->string('Participant1')->nullable();
            $table->string('Participant2')->nullable();
            $table->string('Participant3')->nullable();
            $table->string('Participant4')->nullable();
            $table->string('Participant5')->nullable();
            $table->string('Participant6')->nullable();
            $table->foreignId('User_id');
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
        Schema::dropIfExists('cases');
    }
}
