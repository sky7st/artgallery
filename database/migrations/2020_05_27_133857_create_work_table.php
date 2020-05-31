<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('artist_id');
            $table->string('type')->nullable();
            $table->string('medium')->nullable();
            $table->string('style')->nullable();
            $table->string('size')->nullable();
            $table->string('descript')->nullable();
            $table->string('image_thumb')->nullable();
            $table->string('image_path')->nullable();
            $table->string('asking_price');
            $table->bigInteger('trade_id')->nullable();
            $table->date('date_of_show')->nullable();
            $table->integer('state')->default(1);
            $table->timestamps();
            
            $table->unique(['title', 'artist_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work');
    }
}
