<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(){
    Schema::create('crybot_plans', function(Blueprint $t){
      $t->id();
      $t->enum('market',['crypto','forex','stocks','indices']);
      $t->enum('type',['regular','scalping','both']);
      $t->decimal('price',10,2);
      $t->integer('duration_days');
      $t->float('tp_pct')->default(1.0);
      $t->float('sl_pct')->default(0.5);
      $t->timestamps();
    });
  }
  public function down(){ Schema::dropIfExists('crybot_plans'); }
};
