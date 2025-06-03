<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTables extends Migration
{
    public function up()
    {
        Schema::create('options_series', function(Blueprint $t) {
            $t->id();
            $t->string('symbol'); // e.g. BTC-USD-20250630-CALL-30000
            $t->decimal('strike',10,2);
            $t->string('type'); // 'call' or 'put'
            $t->date('expiry');
            $t->timestamps();
        });

        Schema::create('option_orders', function(Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained();
            $t->foreignId('series_id')->constrained('options_series');
            $t->integer('quantity');
            $t->decimal('price',10,2);
            $t->string('side'); // buy/sell
            $t->string('status')->default('open');
            $t->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('option_orders');
        Schema::dropIfExists('options_series');
    }
}
