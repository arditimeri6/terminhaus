<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unzuteilbar')->nullable();
            $table->string('zeitlich_nicht_geschafft')->nullable();
            $table->string('berater_nicht_besucht')->nullable();
            $table->string('kunde_nicht_auffindbar')->nullable();
            $table->string('falsche_adresse')->nullable();
            $table->string('kunde_nicht_err')->nullable();
            $table->string('nicht_zu_hause')->nullable();
            $table->string('wollte_kein_termin')->nullable();
            $table->string('verspatet_angemeldet')->nullable();
            $table->string('stattgefunden')->nullable();
            $table->string('konnte_nicht_beraten')->nullable();
            $table->string('mjv')->nullable();
            $table->string('behandlung')->nullable();
            $table->string('zu_alt')->nullable();
            $table->string('socialfall')->nullable();
            $table->string('schulden_betreibung')->nullable();
            $table->string('negativ')->nullable();
            $table->string('offen')->nullable();
            $table->string('positiv')->nullable();
            $table->string('kvg_vvg')->nullable();
            $table->string('nur_vvg')->nullable();
            $table->string('andere')->nullable();
            $table->string('comment', 500)->nullable();
            $table->integer('appointment_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->longText('photos')->nullable();
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_feedback');
    }
}
