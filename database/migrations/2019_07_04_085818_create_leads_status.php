<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('call_status');
            $table->string('qc_status')->nullable();
            $table->unsignedInteger('lead_id');
            $table->unsignedInteger('agent_id');
            $table->unsignedInteger('qc_id')->nullable();
            $table->timestamps();

            $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('qc_id')->references('id')->on('users')->onDelete('cascade');
        });
       

    }

    /**
     * Reverse the migrations.
     *
     * @return void   
     */
    public function down()
    {
        Schema::dropIfExists('leads_status');
    }
}
