<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(){
    Schema::create('disputes', function(Blueprint $t){
      $t->id();
      $t->foreignId('trade_id')->constrained('p2p_trades')->cascadeOnDelete();
      $t->foreignId('user_id')->constrained()->cascadeOnDelete();
      $t->text('reason');
      $t->text('message')->nullable();
      $t->enum('status', ['open','under_review','resolved','rejected'])->default('open');
      $t->timestamps();
    });
  }
  public function down(){
    Schema::dropIfExists('disputes');
  }
};
