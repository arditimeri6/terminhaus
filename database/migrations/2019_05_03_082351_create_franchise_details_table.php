<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amount');
            $table->integer('franchise_id')->unsigned();
            $table->timestamps();

            $table->foreign('franchise_id')->references('id')->on('franchises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('franchise_details');
    }
}
