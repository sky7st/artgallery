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
            $table->string('image_path')->nullable();
            $table->string('asking_price');
            $table->date('date_of_show')->nullable();
            $table->date('date_sold')->nullable();
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
