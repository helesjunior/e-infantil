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
        $code = \App\Models\Code::create(['description' => 'Tipo de Usuário', 'is_visible' => false]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'USU',
            'description' => 'Usuário Assefaz',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'PRE',
            'description' => 'Usuário Prestador',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'INS',
            'description' => 'Usuário Instituição',
            'is_visible' => true
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
