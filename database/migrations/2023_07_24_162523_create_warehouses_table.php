<?php

use App\Enums\Currency;
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
        Schema::create('warehouses', static function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->foreignUuid('responsible_user_id')->constrained('users');
            $table->double('return_cost');
            $table->enum('currency', Currency::values())->default(Currency::EUR->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
