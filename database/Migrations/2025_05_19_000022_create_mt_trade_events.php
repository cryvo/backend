<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtTradeEvents extends Migration
{
    public function up()
    {
        Schema::create('mt_trade_events', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('symbol');
            $t->decimal('volume',20,8);
            $t->decimal('price',20,8);
            $t->string('type');
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mt_trade_events');
    }
}
