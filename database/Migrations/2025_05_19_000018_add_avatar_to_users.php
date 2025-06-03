<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function(Blueprint $t){
            $t->string('avatar_url')->nullable();
        });
    }
    public function down()
    {
        Schema::table('users', function(Blueprint $t){
            $t->dropColumn('avatar_url');
        });
    }
}
