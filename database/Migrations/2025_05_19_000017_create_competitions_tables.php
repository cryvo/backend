<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionsTables extends Migration
{
    public function up()
    {
        Schema::create('competitions', function(Blueprint $t){
            $t->id();
            $t->string('name');
            $t->timestamp('starts_at');
            $t->timestamp('ends_at');
            $t->timestamps();
        });

        Schema::create('competition_entries', function(Blueprint $t){
            $t->id();
            $t->foreignId('competition_id')->constrained();
            $t->foreignId('user_id')->constrained();
            $t->decimal('profit', 20, 8)->default(0);
            $t->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('competition_entries');
        Schema::dropIfExists('competitions');
    }
}
