<?php
// database/migrations/2025_05_18_000000_add_fee_and_pair_to_trades_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeeAndPairToTradesTable extends Migration
{
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {
            if (!Schema::hasColumn('trades', 'fee_amount')) {
                $table->decimal('fee_amount', 16, 8)->default(0)->after('amount_usd');
            }
            if (!Schema::hasColumn('trades', 'pair')) {
                $table->string('pair')->index()->after('fee_amount');
            }
        });
    }

    public function down()
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropColumn(['fee_amount', 'pair']);
        });
    }
}
