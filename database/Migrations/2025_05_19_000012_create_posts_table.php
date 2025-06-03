<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up(){
        Schema::create('posts',function(Blueprint $t){
          $t->id();
          $t->string('slug')->unique();
          $t->string('title');
          $t->text('excerpt');
          $t->longText('content');
          $t->timestamp('published_at')->nullable();
          $t->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('posts'); }
}
