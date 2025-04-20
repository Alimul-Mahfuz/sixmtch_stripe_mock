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
        Schema::create('strip_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id')->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('card_number');
            $table->string('name_on_card');
            $table->decimal('price', 8, 2);
            $table->string('billing_address');
            $table->boolean('is_success');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('strip_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
