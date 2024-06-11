<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CodeItemRequest;
use App\Http\Traits\CommonFields;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CodeItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CodeItemCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use CommonFields;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        if (!backpack_user()->can('administracao_outros_codigo_itens_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        $code = \Route::current()->parameter('code');

        CRUD::setModel(\App\Models\CodeItem::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . "/administracao/codigo/$code/item");
        CRUD::setEntityNameStrings('código item', 'código itens');
        CRUD::addClause('where', 'code_id', '=', $code);
        CRUD::orderBy('description', 'asc');

        // deny access according to configuration file
        if (!backpack_user()->can('administracao_outros_codigo_itens_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('administracao_outros_codigo_itens_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('administracao_outros_codigo_itens_deletar')) {
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
        $this->crud->addButtonFromView('top', 'code', 'back.code', 'end');

        CRUD::addColumn([
            'name'  => 'code_description',
            'label' => 'Código descrição',
            'type'  => 'string'
        ]);

        CRUD::addColumn([
            'name'  => 'short_description',
            'label' => 'Descrição curta',
            'type'  => 'string'
        ]);

        CRUD::addColumn([
            'name'  => 'description',
            'label' => 'Descrição',
            'type'  => 'string'
        ]);

        CRUD::addColumn([
            'name'  => 'is_visible',
            'label' => 'Visível?',
            'type'  => 'boolean'
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
        CRUD::setValidation(CodeItemRequest::class);

        $this->addFieldCodeIdHidden();
        $this->addFieldShortDescriptionText();
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
