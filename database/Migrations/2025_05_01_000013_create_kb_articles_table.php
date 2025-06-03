// 2025_05_01_000013_create_kb_articles_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
  public function up(){
    Schema::create('kb_articles', function(Blueprint $t){
      $t->id();
      $t->foreignId('category_id')->constrained('kb_categories');
      $t->string('title');
      $t->string('slug')->unique();
      $t->longText('content');
      $t->timestamps();
    });
  }
  public function down(){ Schema::dropIfExists('kb_articles'); }
};
