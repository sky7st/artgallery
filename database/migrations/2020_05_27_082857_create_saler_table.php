<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saler', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('saler_ssn')->unique(); 
            $table->string('saler_email')->unique();
            $table->string('name');
            $table->string('phone');
            $table->bigInteger('total_sale')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saler');
    }
}
