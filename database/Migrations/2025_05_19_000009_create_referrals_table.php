<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    public function up()
    {
        Schema::create('referrals', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('code')->unique();
            $t->integer('reward_points')->default(0);
            $t->timestamps();
        });

        Schema::create('referral_uses', function(Blueprint $t){
            $t->id();
            $t->foreignId('referral_id')->constrained()->cascadeOnDelete();
            $t->foreignId('referred_user_id')->constrained('users')->cascadeOnDelete();
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_uses');
        Schema::dropIfExists('referrals');
    }
}
