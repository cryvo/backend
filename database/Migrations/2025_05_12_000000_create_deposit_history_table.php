<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(){
    Schema::create('deposit_history', function(Blueprint $t){
      $t->id();
      $t->foreignId('user_id')->constrained();
      $t->string('asset');
      $t->string('address');
      $t->timestamps();
    });
  }
  public function down(){ Schema::dropIfExists('deposit_history'); }
};
