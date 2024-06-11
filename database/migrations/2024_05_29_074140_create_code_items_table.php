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
        Schema::create('code_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('code_id')->constrained()->onDelete('cascade');
            $table->string('short_description', 50)->nullable();
            $table->string('description', 200);
            $table->boolean('is_visible')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_items');
    }
};
