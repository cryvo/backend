<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(){
        Schema::create('deposits', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('asset');
            $t->decimal('amount',30,8);
            $t->string('tx_hash')->nullable();
            $t->enum('status',['pending','completed','failed'])->default('pending');
            $t->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('deposits');
    }
};
