<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(){
        Schema::create('users', function(Blueprint $t){
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->string('phone')->unique()->nullable();
            $t->timestamp('email_verified_at')->nullable();
            $t->string('password');
            $t->boolean('is_vip')->default(false);
            $t->enum('kyc_status',['pending','approved','rejected'])->default('pending');
            $t->rememberToken();
            $t->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('users');
    }
};
