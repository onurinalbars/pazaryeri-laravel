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
        Schema::create('vendor_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('pos_api_key')->nullable();
            $table->string('pos_api_secret')->nullable();
            $table->string('pos_merchant_id')->nullable();
            $table->string('pos_terminal_id')->nullable();
            $table->string('pos_environment')->nullable();
            $table->json('extra_payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_settings');
    }
};
