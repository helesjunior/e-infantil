<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CodeRequest;
use App\Http\Traits\CommonFields;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CodeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CodeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\Pro\Http\Controllers\Operations\DropzoneOperation { dropzoneUpload as traitDropzone; }
    use CommonFields;
//    use \Backpack\ActivityLog\Http\Controllers\Operations\ModelActivityOperation;
//    use \Backpack\ActivityLog\Http\Controllers\Operations\EntryActivityOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        if (!backpack_user()->can('administracao_outros_codigo_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        CRUD::setModel(\App\Models\Code::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/administracao/codigo');
        CRUD::setEntityNameStrings('código', 'códigos');
        CRUD::addClause('where', 'is_visible', '=', true);
        CRUD::orderBy('description', 'asc');

        // deny access according to configuration file
        if (!backpack_user()->can('administracao_outros_codigo_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('administracao_outros_codigo_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('administracao_outros_codigo_deletar')) {
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
                'name'  => 'description',
                'label' => 'Descrição',
                'type'  => 'text',

            ],
            [
                'name'  => 'is_visible',
                'label' => 'Visível?',
                'type'  => 'boolean',
                // optionally override the Yes/No texts
                 'options' => [0 => 'Não', 1 => 'Sim']
            ],
        ]);

        $this->crud->addButtonFromView('line', 'more_items', 'more.items', 'end');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CodeRequest::class);

        $this->addFieldDescriptionText();
        $this->addFieldIsVisibleCheckbox();

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
}
