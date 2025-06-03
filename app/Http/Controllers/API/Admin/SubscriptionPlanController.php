<?php
// File: backend/database/migrations/2025_05_22_000007_create_bot_settings_table.php

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
            $table->json('config')->nullable(); // e.g. scan_interval, default strategies
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bot_settings');
    }
}
