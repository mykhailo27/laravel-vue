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
        Schema::create('countries', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('alpha_2');
            $table->string('alpha_3');
            $table->boolean('enabled')->default(false);
            $table->json('aliases');
            $table->string('zip_code_regex');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
