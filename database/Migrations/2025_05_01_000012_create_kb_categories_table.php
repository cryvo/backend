// 2025_05_01_000012_create_kb_categories_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
  public function up(){
    Schema::create('kb_categories', function(Blueprint $t){
      $t->id();
      $t->string('name')->unique();
      $t->timestamps();
    });
  }
  public function down(){ Schema::dropIfExists('kb_categories'); }
};
