<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(){
    Schema::create('crybot_subscriptions', function(Blueprint $t){
      $t->id(); $t->foreignId('user_id')->constrained();
      $t->enum('market',['crypto','forex','stocks','indices']);
      $t->dateTime('expires_at');
      $t->string('telegram_invite_link')->nullable();
      $t->enum('mode',['regular','scalping','both'])->default('regular');
      $t->foreignId('plan_id')->nullable()->constrained('crybot_plans');
      $t->timestamps();
    });
  }
  public function down(){ Schema::dropIfExists('crybot_subscriptions'); }
};
