<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(){
        Schema::create('orders', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('symbol');
            $t->enum('side',['buy','sell']);
            $t->enum('type',['market','limit','stop-limit']);
            $t->decimal('price',30,8)->nullable();
            $t->decimal('amount',30,8);
            $t->decimal('filled',30,8)->default(0);
            $t->enum('status',['open','filled','cancelled'])->default('open');
            $t->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('orders');
    }
};
