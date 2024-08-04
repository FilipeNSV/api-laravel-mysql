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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('quantity');
            $table->enum('type', ['entry', 'exit'])->default('ENTRY');
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->onDelete('cascade');
            $table->morphs('ownable');
            $table->timestamps();
            $table->softDeletes();
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
