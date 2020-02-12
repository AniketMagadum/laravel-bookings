<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTalentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_talent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('talent_id')->unsigned();
            $table->integer('amount');
            $table->timestamps();
        });

        Schema::table('event_talent', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('talent_id')->references('id')->on('talents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_talent', function (Blueprint $table) {
            $table->dropForeign('event_talent_event_id_foreign');
            $table->dropForeign('event_talent_talent_id_foreign');
        });
        Schema::dropIfExists('event_talent');
    }
}
