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
        Schema::create('church_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('church_id');
            $table->unsignedBigInteger('item_type_id');
            $table->unsignedBigInteger('situation_id');
            $table->string('observation')->nullable();
            $table->integer('amount')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
            $table->foreign('item_type_id')->references('id')->on('code_items')->onDelete('cascade');
            $table->foreign('situation_id')->references('id')->on('code_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_items');
    }
};
