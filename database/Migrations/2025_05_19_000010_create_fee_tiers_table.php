<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeTiersTable extends Migration
{
    public function up()
    {
        Schema::create('fee_tiers', function(Blueprint $t){
            $t->id();
            $t->string('name');
            $t->decimal('min_volume_usd', 20,2);
            $t->decimal('maker_fee',5,2);
            $t->decimal('taker_fee',5,2);
            $t->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('fee_tiers'); }
}
