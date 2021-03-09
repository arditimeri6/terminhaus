<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectorPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('director_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('first_partner');
            $table->string('first_partner_name');
            $table->unsignedInteger('second_partner');
            $table->string('second_partner_name');
            $table->timestamps();

            $table->foreign('first_partner')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('second_partner')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('director_partners');
    }
}
