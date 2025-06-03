// 2025_05_01_000014_create_support_tickets_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
  public function up(){
    Schema::create('support_tickets', function(Blueprint $t){
      $t->id();
      $t->foreignId('user_id')->constrained()->cascadeOnDelete();
      $t->string('subject');
      $t->text('message');
      $t->enum('status',['open','pending','resolved'])->default('open');
      $t->timestamps();
    });
  }
  public function down(){ Schema::dropIfExists('support_tickets'); }
};
