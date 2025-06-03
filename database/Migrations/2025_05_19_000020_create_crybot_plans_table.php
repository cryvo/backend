<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrybotPlansTable extends Migration
{
    public function up()
    {
        Schema::create('crybot_plans', function(Blueprint $t) {
            $t->id();
            $t->string('name');                    // e.g. “Scalping”, “Regular”
            $t->decimal('price_usd', 8,2);
            $t->string('frequency')->default('sec'); // “sec”, “min”, etc.
            $t->json('features');                  // indicators, max SL/TP, etc.
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crybot_plans');
    }
}
