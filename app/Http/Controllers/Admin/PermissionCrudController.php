<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CrudController;
use App\Http\Requests\PermissionStoreCrudRequest as StoreRequest;
use App\Http\Requests\PermissionUpdateCrudRequest as UpdateRequest;
use Spatie\Permission\PermissionRegistrar;

// VALIDATION

class PermissionCrudController extends CrudController
{
    protected string $role_model;
    protected string $permission_model;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        if (!backpack_user()->can('administracao_habilitacao_permissao_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        $this->role_model = $role_model = config('backpack.permissionmanager.models.role');
        $this->permission_model = $permission_model = config('backpack.permissionmanager.models.permission');

        $this->crud->setModel($permission_model);
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.permission_singular'), trans('backpack::permissionmanager.permission_plural'));
        $this->crud->setRoute('/administracao/permissao');

        // deny access according to configuration file
        if (!backpack_user()->can('administracao_habilitacao_permissao_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('administracao_habilitacao_permissao_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('administracao_habilitacao_permissao_deletar')) {
            $this->crud->denyAccess('delete');
        }
    }

    public function setupListOperation()
    {
        $this->crud->addColumn([
            'name'  => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type'  => 'text',
        ]);

        if (config('backpack.permissionmanager.multiple_guards')) {
            $this->crud->addColumn([
                'name'  => 'guard_name',
                'label' => trans('backpack::permissionmanager.guard_type'),
                'type'  => 'text',
            ]);
        }
    }

    public function setupCreateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(StoreRequest::class);

        //otherwise, changes won't have effect
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function setupUpdateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(UpdateRequest::class);

        //otherwise, changes won't have effect
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function addFields()
    {
        $this->crud->addField([
            'name'  => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type'  => 'text',
        ]);

        if (config('backpack.permissionmanager.multiple_guards')) {
            $this->crud->addField([
                'name'    => 'guard_name',
                'label'   => trans('backpack::permissionmanager.guard_type'),
                'type'    => 'select_from_array',
                'options' => $this->getGuardTypes(),
            ]);
        }
    }

    /*
     * Get an array list of all available guard types
     * that have been defined in app/config/auth.php
     *
     * @return array
     **/
    private function getGuardTypes()
    {
        $guards = config('auth.guards');

        $returnable = [];
        foreach ($guards as $key => $details) {
            $returnable[$key] = $key;
        }

        return $returnable;
    }
}
