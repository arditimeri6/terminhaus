<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('salutation');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('post_code');
            $table->string('canton');
            $table->string('language');
            $table->string('mobile_number')->nullable();
            $table->boolean('mobile_grant_access')->default(true);
            $table->string('phone_number')->nullable();
            $table->boolean('phone_grant_access')->default(true);
            $table->string('date');
            $table->string('date_for_search');
            $table->string('time');
            $table->string('second_date')->nullable();
            $table->string('second_time')->nullable();
            $table->string('status')->nullable();
            $table->string('house_number');
            $table->string('comment', 500)->nullable();
            $table->longText('photos')->nullable();
            $table->boolean('photo_access_br')->default(true);
            $table->boolean('qccomment_access_cc')->default(true);
            $table->boolean('qccomment_access_br')->default(true);
            $table->string('krankenkassen');
            $table->integer('members_count')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('assigned_from')->unsigned()->nullable();
            $table->integer('assigned_to')->unsigned()->nullable();
            $table->integer('appointment_direktor')->unsigned()->nullable();
            $table->string('created_at_filter');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_from')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('appointment_direktor')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
