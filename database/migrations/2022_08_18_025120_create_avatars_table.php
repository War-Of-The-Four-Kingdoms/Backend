<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvatarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->enum('gender',['male','female']);
            $table->unsignedBigInteger('user');
            $table->foreign('user')->references('id')->on('users');
            $table->unsignedBigInteger('skintone');
            $table->foreign('skintone')->references('id')->on('skintones');
            $table->unsignedBigInteger('hair');
            $table->foreign('hair')->references('id')->on('hairs');
            $table->unsignedBigInteger('face');
            $table->foreign('face')->references('id')->on('faces');
            $table->unsignedBigInteger('top');
            $table->foreign('top')->references('id')->on('tops');
            $table->unsignedBigInteger('accessory');
            $table->foreign('accessory')->references('id')->on('accessories');
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
        Schema::dropIfExists('avatars');
    }
}
