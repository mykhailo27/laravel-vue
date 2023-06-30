<?php

use App\Enums\CompanyState;
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
        Schema::create('companies', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('abbreviation');
            $table->string('vat');
            $table->string('logo')->nullable();
            $table->enum('state', CompanyState::values())->default(CompanyState::DRAFT->value);
            $table->foreignUuid('agency_id')->constrained();
            $table->foreignUuid('owner_id')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
