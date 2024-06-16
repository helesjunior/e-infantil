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
        $code = \App\Models\Code::create(['description' => 'Tipo Item EI', 'is_visible' => true]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'PC',
            'description' => 'Computador',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'IMPRESSORA',
            'description' => 'Impressora',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'ARMARIO',
            'description' => 'Armário',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'TATAME',
            'description' => 'Tatame Emborrachado',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'MESACRI',
            'description' => 'Mesa p/ Crianças',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'CADEIRACRI',
            'description' => 'Cadeira p/ Crianças',
            'is_visible' => true
        ]);


        $code = \App\Models\Code::create(['description' => 'Classificação Item', 'is_visible' => true]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'OTIMO',
            'description' => 'Ótimo',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'BOM',
            'description' => 'Bom',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'REGULAR',
            'description' => 'Regular',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'RUIM',
            'description' => 'Ruim',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'NAOFUNC',
            'description' => 'Não Funciona',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'INADEQUA',
            'description' => 'Inadequado',
            'is_visible' => true
        ]);

        \App\Models\CodeItem::create([
            'code_id' => $code->id,
            'short_description' => 'NOVO',
            'description' => 'Novo',
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
