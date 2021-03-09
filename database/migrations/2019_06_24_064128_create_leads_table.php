<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kunden_type');
            $table->string('salutation');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('year');
            $table->string('mobile_number');
            $table->string('house_number')->nullable();
            $table->string('street');
            $table->string('post_code');
            $table->string('place');
            $table->string('canton');
            $table->string('company_name')->nullable();
            $table->string('comment', 500)->nullable();
            $table->string('status')->nullable();
            $table->string('autoversicherung')->nullable();
            $table->string('hausrat_privathaftpflicht')->nullable();
            $table->string('lebensversicherung')->nullable();
            $table->string('rechtsschutzversicherung')->nullable();
            $table->string('krankenversicherung')->nullable();
            $table->string('vertrag_seit_wann')->nullable();
            $table->string('letzte_optimierung')->nullable();
            $table->string('anzahl_personen')->nullable();
            $table->string('anruf_erwünscht')->nullable();
            $table->string('ereichbar')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('assigned_from')->unsigned()->nullable();
            $table->integer('assigned_to')->unsigned()->nullable();
            $table->integer('leads_direktor')->unsigned()->nullable();
            $table->boolean('qccomment_access_cc')->default(true);
            $table->boolean('qccomment_access_br')->default(true);
            $table->string('created_at_filter');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_from')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('leads_direktor')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
