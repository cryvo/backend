<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('p2p_trades', function(Blueprint $t) {
            $t->decimal('escrow_amount',30,8)->after('amount');
            $t->enum('escrow_status',['pending','released','disputed'])
              ->default('pending')->after('escrow_amount');
            $t->timestamp('escrow_release_at')
              ->nullable()->after('escrow_status');
        });
    }
    public function down() {
        Schema::table('p2p_trades', function(Blueprint $t){
            $t->dropColumn(['escrow_amount','escrow_status','escrow_release_at']);
        });
    }
};
