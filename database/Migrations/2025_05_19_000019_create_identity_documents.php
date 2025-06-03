<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentityDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('identity_documents', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('type');       // passport, id_card, driver_license
            $t->string('file_path');
            $t->string('status')->default('pending'); // pending, approved, rejected
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('identity_documents');
    }
}
