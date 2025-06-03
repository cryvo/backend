<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiKeysTable extends Migration
{
    public function up(){
        Schema::create('api_keys',function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('key',80)->unique();
            $t->timestamp('revoked_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('api_keys'); }
}
