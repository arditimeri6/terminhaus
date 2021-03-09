<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKundensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kundens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('plz');
            $table->string('ort');
            $table->string('address');
            $table->string('lat');
            $table->string('lng');
            $table->string('telefon');
            $table->integer('berater_id')->unsigned()->nullable();
            $table->integer('client_source_id')->unsigned()->nullable();
            $table->integer('types_of_contract_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('basic_insurance_model_id')->unsigned()->nullable();
            $table->boolean('accident_cover')->nullable();
            $table->integer('franchise_id')->unsigned()->nullable();
            $table->integer('franchise_details_id')->unsigned()->nullable();
            $table->string('basic_insurance_start_date')->nullable();
            $table->integer('hospital_id')->unsigned()->nullable();
            $table->integer('inpatients_id')->unsigned()->nullable();
            $table->integer('alternative_medical_id')->unsigned()->nullable();
            $table->integer('dental_id')->unsigned()->nullable();
            $table->string('combi')->nullable();
            $table->string('accident')->nullable();
            $table->string('death')->nullable();
            $table->string('taggeld')->nullable();
            $table->string('other')->nullable();
            $table->boolean('legal')->nullable();
            $table->integer('product_type_id')->unsigned()->nullable();
            $table->string('insurance_commencement_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('yearly_premium')->nullable();
            $table->string('monthly_premium')->nullable();
            $table->string('redeemable')->nullable();
            $table->string('occupation')->nullable();
            $table->string('smoker')->nullable();
            $table->string('value')->nullable();
            $table->integer('options_id')->unsigned()->nullable();
            $table->integer('payment_id')->unsigned()->nullable();
            $table->integer('payment_type_id')->unsigned()->nullable();
            $table->string('contract_signed_on')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('berater_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_source_id')->references('id')->on('client_sources')->onDelete('cascade');
            $table->foreign('types_of_contract_id')->references('id')->on('types_of_contracts')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('basic_insurance_model_id')->references('id')->on('basic_insurance_models')->onDelete('cascade');
            $table->foreign('franchise_id')->references('id')->on('franchises')->onDelete('cascade');
            $table->foreign('franchise_details_id')->references('id')->on('franchise_details')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->foreign('inpatients_id')->references('id')->on('inpatients')->onDelete('cascade');
            $table->foreign('alternative_medical_id')->references('id')->on('alternative_medicals')->onDelete('cascade');
            $table->foreign('dental_id')->references('id')->on('dentals')->onDelete('cascade');
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->foreign('options_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('payment_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kundens');
    }
}
