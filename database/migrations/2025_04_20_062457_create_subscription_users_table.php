<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_plan_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans');
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_active')->default(false);
            $table->timestamp('expires_at');
            $table->string('transaction_id');
            $table->boolean('is_autorenew');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_user');
    }
};
