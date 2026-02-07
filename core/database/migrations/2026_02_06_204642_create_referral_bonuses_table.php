<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('referral_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('referral_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 28, 8);
            $table->string('type'); // 'signup', 'deposit', 'investment'
            $table->string('description')->nullable();
            $table->boolean('paid')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'paid']);
            $table->index(['referral_id', 'paid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_bonuses');
    }
};