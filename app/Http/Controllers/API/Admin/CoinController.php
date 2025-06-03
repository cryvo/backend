<?php
// File: backend/database/migrations/2025_05_22_000002_create_markets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketsTable extends Migration
{
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol')->unique();
            $table->json('config')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('markets');
    }
}
