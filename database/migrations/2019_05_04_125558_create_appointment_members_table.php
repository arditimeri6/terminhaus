<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('salutation');
            $table->string('first_name');
            $table->string('krankenkassen');
            $table->string('birth_year');
            $table->string('contract_duration');
            $table->string('behandlung');
            $table->integer('appointment_id')->unsigned();
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_members');
    }
}
