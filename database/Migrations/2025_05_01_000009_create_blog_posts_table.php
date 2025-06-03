// 2025_05_01_000009_create_blog_posts_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
  public function up(){
    Schema::create('blog_posts', function(Blueprint $t){
      $t->id();
      $t->foreignId('category_id')->constrained('blog_categories');
      $t->string('title');
      $t->string('slug')->unique();
      $t->text('excerpt');
      $t->longText('content');
      $t->string('image')->nullable();
      $t->enum('status',['draft','published'])->default('draft');
      $t->timestamps();
    });
  }
  public function down(){ Schema::dropIfExists('blog_posts'); }
};
