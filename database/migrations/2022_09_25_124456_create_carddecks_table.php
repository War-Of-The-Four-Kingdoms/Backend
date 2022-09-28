<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarddecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carddecks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game');
            $table->foreign('game')->references('id')->on('games');
            $table->unsignedBigInteger('card');
            $table->foreign('card')->references('id')->on('cards');
            $table->boolean('in_use');
            $table->string('code');
            $table->enum('symbol',['club','diamond','heart','spade']);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_deck');
    }
}
