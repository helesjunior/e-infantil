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
        \Spatie\Permission\Models\Permission::create(['name' => 'cadastro_contratos_acesso', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'cadastro_contratos_criar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'cadastro_contratos_editar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'cadastro_contratos_deletar', 'guard_name' => 'web']);

        $role = \Spatie\Permission\Models\Role::where('name', 'Administrador Master')->firstOrFail();

        $role->givePermissionTo(\Spatie\Permission\Models\Permission::all());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
