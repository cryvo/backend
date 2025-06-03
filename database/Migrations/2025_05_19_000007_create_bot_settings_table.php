<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('bot_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('config')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bot_settings');
    }
}
