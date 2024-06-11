<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CboRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CboCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CboCrudController extends CrudController
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
        if (!backpack_user()->can('administracao_outros_cbo_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        CRUD::setModel(\App\Models\Cbo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/administracao/cbo');
        CRUD::setEntityNameStrings('cbo', 'cbos');
        CRUD::orderBy('description', 'asc');

        // deny access according to configuration file
        if (!backpack_user()->can('administracao_outros_cbo_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('administracao_outros_cbo_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('administracao_outros_cbo_deletar')) {
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

        CRUD::addColumns([
            [
                'name' => 'tuss_code_description',
                'label' => 'TUSS',
                'type' => 'string'
            ],
            [
                'name' => 'code',
                'label' => 'Código',
                'type' => 'string'
            ],
            [
                'name' => 'description',
                'label' => 'Descrição',
                'type' => 'string'
            ],
            [
                'name' => 'status',
                'label' => 'Ativo?',
                'type' => 'boolean'
            ]
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

        CRUD::setValidation(CboRequest::class);

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
                'name' => 'tuss_id',
                'label' => 'TUSS',
                'type' => 'select2',
                'entity'    => 'tuss', // the method that defines the relationship in your Model
                'model'     => "App\Models\Tuss", // foreign key model
                'attribute' => 'tuss_code_description', // foreign key attribute that is shown to user
//                'default'   => 2, // set the default value of the select2
                // also optional
                'options'   => (function ($query) {
                    return $query->orderBy('code', 'ASC')->get();
                }),
            ],
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
