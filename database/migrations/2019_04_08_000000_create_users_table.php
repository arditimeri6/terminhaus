<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->integer('direktor')->unsigned();
            $table->string('quality_responsibility')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('status')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('company_name')->nullable();
            $table->longText('company_logo')->nullable();
            $table->boolean('virtual');
            $table->string('country')->nullable();
            $table->boolean('assign_view_access')->default(true);
            $table->rememberToken();
            $table->timestamps();

        });

        Schema::table('users', function($table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('direktor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
