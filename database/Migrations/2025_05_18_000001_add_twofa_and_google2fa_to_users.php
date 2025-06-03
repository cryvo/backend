<?php
// database/migrations/2025_05_18_000001_add_twofa_and_google2fa_to_users.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwofaAndGoogle2faToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('two_factor_code')->nullable()->after('password');
            $table->timestamp('two_factor_expires_at')->nullable()->after('two_factor_code');

            $table->string('google2fa_secret')->nullable()->after('two_factor_expires_at');
            $table->boolean('google2fa_enabled')->default(false)->after('google2fa_secret');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_code',
                'two_factor_expires_at',
                'google2fa_secret',
                'google2fa_enabled',
            ]);
        });
    }
}
