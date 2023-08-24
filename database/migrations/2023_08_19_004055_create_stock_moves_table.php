<?php

use App\Enums\StockMoveType;
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
        Schema::create('stock_moves', function (Blueprint $table) {
            $table->id();
            $table->enum('type', StockMoveType::values())->type('integer');
            $table->integer('amount')->default(1);
            $table->foreignUuid('company_id')->constrained();
            $table->foreignUuid('warehouse_id')->constrained();
            $table->foreignId('variant_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_moves');
    }
};
