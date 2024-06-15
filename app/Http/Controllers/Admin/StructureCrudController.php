<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StructureRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class StructureCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StructureCrudController extends CrudController
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
        if (!backpack_user()->can('administracao_outros_estrutura_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        CRUD::setModel(\App\Models\Structure::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/administracao/estrutura');
        CRUD::setEntityNameStrings('estrutura', 'estrutura');
        CRUD::orderBy('level_id', 'asc');
        CRUD::orderBy('description', 'asc');

        // deny access according to configuration file
        if (!backpack_user()->can('administracao_outros_estrutura_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('administracao_outros_estrutura_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('administracao_outros_estrutura_deletar')) {
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
                'name' => 'parent_description',
                'label' => 'Pai',
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
        CRUD::setValidation(StructureRequest::class);

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
                'name' => 'parent_id',
                'label' => 'Pai',
                'type' => 'select2',
                'entity'    => 'parent', // the method that defines the relationship in your Model
                'model'     => "App\Models\Structure", // foreign key model
                'attribute' => 'description', // foreign key attribute that is shown to user
//                'default'   => 2, // set the default value of the select2
                // also optional

                'options'   => (function ($query) {
                    return $query
                        ->groupBy(['level_id','parent_id','id'])
                        ->orderBy('level_id', 'ASC')
                        ->orderBy('parent_id', 'ASC')
                        ->orderBy('description', 'ASC')
//                        ->orderBy('id', 'ASC')
                        ->get();
                }),
            ],
//            [
//                'name' => 'parent_id',
//                'label' => 'Pai',
//                'type' => 'select_grouped',
//                'entity' => 'parent', // the method that defines the relationship in your Model
////                'model'     => "App\Models\Structure", // foreign key model
//                'attribute' => 'description', // foreign key attribute that is shown to user
////                'default'   => 2, // set the default value of the select2
//                // also optional
//                'group_by' => 'level',
//                'group_by_attribute' => 'description',
//                'group_by_relationship_back' => 'structures',
//                'options' => (function ($query) {
//                    return $query
//                        ->whereHas('code', function ($q) {
//                            $q->where('description', 'Tipo Nível Hierarquia');
//                        })
//                        ->orderBy('description', 'ASC')
////                        ->groupBy('level')
////                        ->orderBy('parent_id', 'ASC')
////                        ->orderBy('description', 'ASC')
////                        ->orderBy('id', 'ASC')
//                        ->get();
//                }),
//            ],
            [
                'name' => 'description',
                'label' => 'Descrição',
                'type' => 'text',
            ],
            [
                'name' => 'level_id',
                'label' => 'Nível',
                'type' => 'select2',
                'entity' => 'level', // the method that defines the relationship in your Model
                'model' => "App\Models\Codeitem", // foreign key model
                'attribute' => 'description', // foreign key attribute that is shown to user
                'options' => (function ($query) {
                    return $query
                        ->whereHas('code', function ($q) {
                            $q->where('description', 'Tipo Nível Hierarquia');
                        })
                        ->orderBy('description', 'ASC')
//                        ->orderBy('description', 'ASC')
//                        ->orderBy('id', 'ASC')
                        ->get();
                }),
            ],
//            [   // select_from_array
//                'name' => 'level',
//                'label' => "Tipo",
//                'type' => 'select_from_array',
//                'options' => [
//                    '1' => 'CCB Brás',
//                    '2' => 'Regional',
//                    '3' => 'Administração',
//                    '4' => 'Setor',
//                ],
//                'allows_null' => true,
//                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
//            ],
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
