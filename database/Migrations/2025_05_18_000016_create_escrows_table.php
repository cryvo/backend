<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('escrows', function(Blueprint $t){
            $t->id();
            $t->foreignId('trade_id')->constrained('p2p_trades')->cascadeOnDelete();
            $t->foreignId('buyer_id')->constrained('users');
            $t->foreignId('seller_id')->constrained('users');
            $t->string('asset');
            $t->decimal('amount',30,8);
            $t->boolean('buyer_confirmed')->default(false);
            $t->boolean('seller_confirmed')->default(false);
            $t->timestamp('released_at')->nullable();
            $t->enum('status',['in_escrow','released','cancelled'])->default('in_escrow');
            $t->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('escrows');
    }
};
