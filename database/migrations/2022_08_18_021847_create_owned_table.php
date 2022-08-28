<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owneds', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_equiped');
            $table->unsignedBigInteger('player');
            $table->foreign('player')->references('id')->on('players');
            $table->unsignedBigInteger('card');
            $table->foreign('card')->references('id')->on('cards');
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
        Schema::dropIfExists('own_cards');
    }
}
