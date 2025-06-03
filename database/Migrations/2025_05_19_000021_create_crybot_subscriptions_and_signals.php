<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrybotSubscriptionsAndSignals extends Migration
{
    public function up()
    {
        Schema::create('crybot_subscriptions', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('plan_id')->constrained('crybot_plans');
            $t->timestamp('starts_at')->useCurrent();
            $t->timestamp('ends_at')->nullable();
            $t->string('status')->default('active'); // active, cancelled
            $t->timestamps();
        });

        Schema::create('crybot_signals', function(Blueprint $t){
            $t->id();
            $t->foreignId('subscription_id')->constrained('crybot_subscriptions');
            $t->string('market');     // “BTC/USD”, “EUR/USD”, “XAU/USD”
            $t->string('type');       // “entry”, “exit”
            $t->string('side');       // “buy”|“sell”
            $t->decimal('price', 12,6);
            $t->timestamp('sent_at')->useCurrent();
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crybot_signals');
        Schema::dropIfExists('crybot_subscriptions');
    }
}
