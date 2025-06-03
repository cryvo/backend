<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('action');            // e.g. "kyc_approved" or "kyc_rejected"
            $table->string('target_type');       // e.g. "user"
            $table->unsignedBigInteger('target_id');
            $table->json('metadata')->nullable(); // e.g. old vs new status
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audit_logs');
    }
}
