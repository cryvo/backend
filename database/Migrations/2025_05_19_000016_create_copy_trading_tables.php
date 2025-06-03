<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCopyTradingTables extends Migration
{
    public function up()
    {
        Schema::create('master_traders', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained();
            $t->string('alias');
            $t->json('config')->nullable();
            $t->timestamps();
        });

        Schema::create('copy_trades', function(Blueprint $t){
            $t->id();
            $t->foreignId('follower_id')->constrained('users');
            $t->foreignId('master_id')->constrained('master_traders');
            $t->foreignId('trade_id')->constrained('trades');
            $t->decimal('amount',20,8);
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('copy_trades');
        Schema::dropIfExists('master_traders');
    }
}
