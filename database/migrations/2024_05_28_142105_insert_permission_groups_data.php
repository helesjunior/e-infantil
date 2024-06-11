<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_acesso', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_acesso', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_usuario_acesso', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_usuario_criar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_usuario_editar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_usuario_deletar', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_grupo_acesso', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_grupo_criar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_grupo_editar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_grupo_deletar', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_permissao_acesso', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_permissao_criar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_permissao_editar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_habilitacao_permissao_deletar', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_acesso', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_codigo_acesso', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_codigo_criar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_codigo_editar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_codigo_deletar', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_codigo_itens_acesso', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_codigo_itens_criar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_codigo_itens_editar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_codigo_itens_deletar', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_tuss_acesso', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_tuss_criar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_tuss_editar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_tuss_deletar', 'guard_name' => 'web']);

        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_cbo_acesso', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_cbo_criar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_cbo_editar', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Permission::create(['name' => 'administracao_outros_cbo_deletar', 'guard_name' => 'web']);


        $role = \Spatie\Permission\Models\Role::create(['name' => 'Administrador Master', 'guard_name' => 'web']);

        $role->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        $user = \App\Models\User::create([
            'cpf' => '11111111111',
            'name' => 'Usuário Administrador',
            'email' => 'admin@assefaz.org.br',
            'password' => Hash::make('123456'),
        ]);

        $user->assignRole($role);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
