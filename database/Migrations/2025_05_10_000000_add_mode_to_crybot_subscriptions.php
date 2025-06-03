<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(){
    Schema::table('crybot_subscriptions', function(Blueprint $t){
      $t->enum('mode',['regular','scalping','both'])->default('regular')->after('market');
    });
  }
  public function down(){
    Schema::table('crybot_subscriptions', function(Blueprint $t){
      $t->dropColumn('mode');
    });
  }
};
