<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(){
        Schema::create('wallets', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('asset');
            $t->decimal('balance', 30, 8)->default(0);
            $t->timestamps();
            $t->unique(['user_id','asset']);
        });
    }
    public function down(){
        Schema::dropIfExists('wallets');
    }
};
