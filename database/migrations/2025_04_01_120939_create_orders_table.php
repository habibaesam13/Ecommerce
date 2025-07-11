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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->decimal("total_price");
            $table->enum("status",['pending', 'processing', 'shipped', 'delivered', 'cancelled']);
            $table->enum("payment_status",['pending', 'paid', 'failed', 'refunded']);
            $table->string("tracking_number")->unique();
            $table->timestamps();
            $table->foreign("user_id")->references('id')->on('users')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
