<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarnProductsTables extends Migration
{
    public function up()
    {
        Schema::create('earn_products', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->decimal('annual_rate', 5, 2);
            $t->integer('term_days')->nullable(); // null = flexible
            $t->json('config')->nullable();
            $t->timestamps();
        });

        Schema::create('user_earn_subscriptions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained();
            $t->foreignId('product_id')->constrained('earn_products');
            $t->decimal('amount', 20, 8);
            $t->timestamp('started_at');
            $t->timestamp('ends_at')->nullable();
            $t->string('status')->default('active');
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_earn_subscriptions');
        Schema::dropIfExists('earn_products');
    }
}
