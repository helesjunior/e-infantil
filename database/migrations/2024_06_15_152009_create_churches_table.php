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
        Schema::create('churches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('structure_id');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            $table->string('ei_operating');//DM, DN, 2N, 3N, 4N, 5N, 6N, SN,
            $table->boolean('computer')->default(false);
            $table->boolean('printer')->default(false);
            $table->boolean('internet')->default(false);
            $table->boolean('tatami')->default(false);
            $table->boolean('white_board')->default(false);
            $table->boolean('cabinet')->default(false);
            $table->integer('children_tables')->default(0);
            $table->integer('children_chairs')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('structure_id')->references('id')->on('structure');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('churches');
    }
};
