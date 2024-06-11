<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tuss = \App\Models\Tuss::create(['code' => '10101012', 'description' => 'Avaliação Clínica']);
        \App\Models\Tuss::create(['code' => '40601137', 'description' => 'Citologia oncótica (Papanicolau coleta e análise)']);
        \App\Models\Tuss::create(['code' => '40808041', 'description' => 'Mamografia, para mulheres']);
        \App\Models\Tuss::create(['code' => '40304361', 'description' => 'Hemograma completo']);
        \App\Models\Tuss::create(['code' => '40302040', 'description' => 'Glicemia']);
        \App\Models\Tuss::create(['code' => '40321210', 'description' => 'Urina Tipo I (Elementos anormais e sedimentoscopio - EAS)']);
        \App\Models\Tuss::create(['code' => '40301630', 'description' => 'Creatinina']);
        \App\Models\Tuss::create(['code' => '40301605', 'description' => 'Colesterol total e triglicérides']);
        \App\Models\Tuss::create(['code' => '40302504', 'description' => 'AST (Transaminase Glutâmica Oxalacética - TGO)']);
        \App\Models\Tuss::create(['code' => '40302512', 'description' => 'ALT (Transaminase Glutâmica Pirúvica - TGP)']);
        \App\Models\Tuss::create(['code' => '40303136', 'description' => 'Pesquisa de sangue oculto nas fezes (método imunocromatográfico);']);
        \App\Models\Tuss::create(['code' => '40316149', 'description' => 'PSA, para homens']);
        \App\Models\Tuss::create(['code' => '40101010', 'description' => 'Eletrocardiograma']);

        \App\Models\Cbo::create(['tuss_id'=> $tuss->id,'code' => '2252-50', 'description' => 'Médico ginecologista e obstetra']);
        \App\Models\Cbo::create(['tuss_id'=> $tuss->id,'code' => '2252-65', 'description' => 'Médico oftalmologista']);
        \App\Models\Cbo::create(['tuss_id'=> $tuss->id,'code' => '2251-40', 'description' => 'Médico do trabalho']);
        \App\Models\Cbo::create(['tuss_id'=> $tuss->id,'code' => '2251-20', 'description' => 'Médico cardiologista']);
        \App\Models\Cbo::create(['tuss_id'=> $tuss->id,'code' => '2515-10', 'description' => 'Psicólogo clínico']);
        \App\Models\Cbo::create(['tuss_id'=> $tuss->id,'code' => '2251-33', 'description' => 'Médico psiquiatra']);
        \App\Models\Cbo::create(['tuss_id'=> $tuss->id,'code' => '2235-05', 'description' => 'Enfermeiro']);
        \App\Models\Cbo::create(['tuss_id'=> $tuss->id,'code' => '2235-30', 'description' => 'Enfermeiro do trabalho']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
