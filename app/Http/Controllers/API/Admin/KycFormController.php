<?php
// File: backend/database/migrations/2025_05_22_000005_create_pages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();     // e.g. 'about','faq','contact'
            $table->string('title');
            $table->json('config')->nullable();   // content blocks, meta, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
