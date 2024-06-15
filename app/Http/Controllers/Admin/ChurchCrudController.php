<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Operations\FetchOperation;
use App\Http\Requests\ChurchRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ChurchCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChurchCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {

        if (!backpack_user()->can('administracao_outros_igreja_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        CRUD::setModel(\App\Models\Church::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/administracao/igreja');
        CRUD::setEntityNameStrings('igreja', 'Igrejas');

        // deny access according to configuration file
        if (!backpack_user()->can('administracao_outros_igreja_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('administracao_outros_igreja_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('administracao_outros_igreja_deletar')) {
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
        CRUD::setFromDb(); // set columns from db columns.

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
        CRUD::setValidation(ChurchRequest::class);

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
                'name' => 'structure_id',
                'label' => 'Estrutura Vinculada',
                'type' => 'select2',
                'entity' => 'structure', // the method that defines the relationship in your Model
                'model' => "App\Models\Structure", // foreign key model
                'attribute' => 'description', // foreign key attribute that is shown to user
                'allows_null' => true,
                'placeholder' => "Selecione a Estrutura Vinculada",
//                'default'   => 2, // set the default value of the select2
                // also optional
                'options' => (function ($query) {
                    return $query
                        ->orderBy('level_id', 'ASC')
                        ->orderBy('description', 'ASC')
                        ->get();
                }),
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'name',
                'label' => 'Nome',
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'attributes' => [
                    'onkeyup' => "maiuscula(this)"
                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'address',
                'label' => 'Endereço',
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'attributes' => [
                    'onkeyup' => "maiuscula(this)"
                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'zip_code',
                'label' => 'CEP (somente número)',
                'type' => 'zipcode',
                'wrapperAttributes' => ['class' => 'form-group col-md-2'],
//                'attributes' => [
//                    'onchange' => "formatZipCode(this)"
//                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'state_id',
                'label' => 'Estado',
                'type' => 'select2',
                'entity' => 'state', // the method that defines the relationship in your Model
                'model' => "App\Models\State", // foreign key model
                'attribute' => 'uf_name', // foreign key attribute that is shown to user
                'allows_null' => true,
                'placeholder' => "Selecione o Estado",
//                'default'   => 2, // set the default value of the select2
                // also optional
                'options' => (function ($query) {
                    return $query->orderBy('uf', 'ASC')->get();
                }),
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'tab' => 'Dados Básicos',
            ],
            [ // select2_from_ajax: 1-n relationship
                'name' => 'city_id',
                'label' => 'Município', // Table column heading
                'type' => 'relationship',
                'ajax' => true,
                'model' => "App\Models\City", // foreign key model
                'entity' => 'city', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'data_source' => url('/church/fetch/city'), // url to controller search function (with /{id} should return model)
                'method' => 'POST', // route method, either GET or POST
                'allows_null' => true,
                'placeholder' => 'Selecione o município', // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
                'dependencies' => ['state_id'],
                'include_all_form_fields' => ['state_id'],
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'tab' => 'Dados Básicos',
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
                'inline' => true,
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'ei_operating',
                'label' => 'Dia(s) Funcionamento',
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'attributes' => [
                    'onkeyup' => "maiuscula(this)"
                ],
                'tab' => 'Espaço Infantil',
            ],
            [   // CustomHTML
                'name'  => 'separator',
                'type'  => 'custom_html',
                'value' => '<label>Informações Adicionais</label><hr style="margin: 0;"/>',
                'tab' => 'Espaço Infantil',
            ],
            [   // Checkbox
                'name'  => 'computer',
                'label' => 'Tem Computador',
                'type'  => 'checkbox',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'tab' => 'Espaço Infantil',
            ],
            [   // Checkbox
                'name'  => 'printer',
                'label' => 'Tem Impressora',
                'type'  => 'checkbox',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'tab' => 'Espaço Infantil',
            ],
            [   // Checkbox
                'name'  => 'internet',
                'label' => 'Tem Internet',
                'type'  => 'checkbox',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'tab' => 'Espaço Infantil',
            ],
            [   // Checkbox
                'name'  => 'tatami',
                'label' => 'Tem Tatame Emborrachado',
                'type'  => 'checkbox',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'tab' => 'Espaço Infantil',
            ],
            [   // Checkbox
                'name'  => 'white_board',
                'label' => 'Tem Quadro Branco',
                'type'  => 'checkbox',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'tab' => 'Espaço Infantil',
            ],
            [   // Checkbox
                'name'  => 'cabinet',
                'label' => 'Tem Armário',
                'type'  => 'checkbox',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'tab' => 'Espaço Infantil',
            ],
            [   // Checkbox
                'name'  => 'children_tables',
                'label' => 'Qtd. Mesas',
                'type'  => 'number',
                'attributes' => ["step" => 'false'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'tab' => 'Espaço Infantil',
            ],
            [   // Checkbox
                'name'  => 'children_chairs',
                'label' => 'Qtd. Cadeiras',
                'type'  => 'number',
                'attributes' => ["step" => 'false'],
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'tab' => 'Espaço Infantil',
            ],
        ]);
    }

    protected function fetchCity()
    {
        return $this->fetch([
            'model' => \App\Models\City::class,
            'searchable_attributes' => [],
            'query' => function ($model) {
                $search = request()->input('q') ?? false;
                $form = backpack_form_input();

                if (!isset($form['state_id']) || empty($form['state_id'])) {
                    return $model->where('state_id', 0);
                }

                if ($search) {
                    return $model->whereRaw("LOWER(cities.name) ILIKE '%" . strtolower($search) . "%'")
                        ->where('state_id', $form['state_id']);
                } else {
                    return $model->where('state_id', $form['state_id']);
                }

            }
        ]);
    }
}
