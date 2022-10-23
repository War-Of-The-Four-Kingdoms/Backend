<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->enum('symbol',['club','diamond','heart','spade']);
            $table->enum('type',['trick','equipment','active']);
            $table->boolean('decision');
            $table->integer('distance');
            $table->enum('affected_gender',['all','male','female']);
            $table->boolean('immediately');
            $table->enum('equipment_type',['weapon','armor','mount'])->nullable();
            $table->enum('active_type',['atk','def','heal'])->nullable();
            $table->string('item_name')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('trick_cards');
    }
}
