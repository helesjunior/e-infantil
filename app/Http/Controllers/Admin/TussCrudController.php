<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TussRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TussCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TussCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        if (!backpack_user()->can('administracao_outros_tuss_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        CRUD::setModel(\App\Models\Tuss::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/administracao/tuss');
        CRUD::setEntityNameStrings('tuss', 'tuss');
        CRUD::orderBy('description', 'asc');

        // deny access according to configuration file
        if (!backpack_user()->can('administracao_outros_tuss_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('administracao_outros_tuss_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('administracao_outros_tuss_deletar')) {
            $this->crud->denyAccess('delete');
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $this->crud->addColumns([
            [
                'name' => 'code',
                'label' => 'Código',
                'type' => 'text',

            ],
            [
                'name' => 'description',
                'label' => 'Descrição',
                'type' => 'text',

            ],
            [
                'name' => 'status',
                'label' => 'Ativo?',
                'type' => 'boolean',
                // optionally override the Yes/No texts
                'options' => [0 => 'Não', 1 => 'Sim']
            ],
        ]);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->addFields();

        CRUD::setValidation(TussRequest::class);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    private function addFields()
    {
        $this->crud->addFields([
            [
                'name' => 'code',
                'label' => 'Código',
                'type' => 'text',
            ],
            [
                'name' => 'description',
                'label' => 'Descrição',
                'type' => 'text',
            ],
            [   // radio
                'name' => 'status', // the name of the db column
                'label' => 'Ativo?', // the input label
                'type' => 'radio',
                'options' => [
                    // the key will be stored in the db, the value will be shown as label;
                    0 => "Não",
                    1 => "Sim"
                ],
                'default' => 1,
                'inline' => true
            ]
        ]);


    }
}
