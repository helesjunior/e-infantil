<?php

namespace App\Http\Controllers\Register;

use App\Http\Requests\ProviderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProviderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProviderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Operations\FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {

        if (!backpack_user()->can('cadastro_prestadores_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        CRUD::setModel(\App\Models\Provider::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cadastro/prestador');
        CRUD::setEntityNameStrings('prestador', 'prestadores');
        CRUD::orderBy('name', 'asc');

        // deny access according to configuration file
        if (!backpack_user()->can('cadastro_prestadores_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('cadastro_prestadores_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('cadastro_prestadores_deletar')) {
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
        CRUD::enableExportButtons();

        $this->crud->addColumns([
            [
                'name' => 'cpf_cnpj',
                'label' => 'CPF / CNPJ',
                'type' => 'text',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'name',
                'label' => 'Nome Completo / Razão Social',
                'type' => 'text',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'email',
                'label' => "E-mail",
                'type' => 'email',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'address',
                'label' => "Endereço",
                'type' => 'text',
                'visibleInTable' => false,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'zip_code',
                'label' => "Cep",
                'type' => 'text',
                'visibleInTable' => false,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                // run a function on the CRUD model and show its return value
                'name' => 'state_id',
                'label' => 'UF', // Table column heading
                'type' => 'model_function',
                'function_name' => 'getStateName', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                // 'limit' => 100, // Limit the number of characters shown
                // 'escaped' => false, // echo using {!! !!} instead of {{ }}, in order to render HTML
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                // run a function on the CRUD model and show its return value
                'name' => 'city_id',
                'label' => 'Município', // Table column heading
                'type' => 'model_function',
                'function_name' => 'getCityName', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                // 'limit' => 100, // Limit the number of characters shown
                // 'escaped' => false, // echo using {!! !!} instead of {{ }}, in order to render HTML
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInExport' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'phone1',
                'label' => "Telefone 1",
                'type' => 'text',
                'visibleInTable' => false,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'phone2',
                'label' => "Telefone 2",
                'type' => 'text',
                'visibleInTable' => false,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                // n-n relationship (with pivot table)
                'label' => 'TUSS', // Table column heading
                'type' => 'select2_multiple',
                'name' => 'tuss', // the method that defines the relationship in your Model
                'entity' => 'tuss', // the method that defines the relationship in your Model
                'attribute' => 'tuss_code_description', // foreign key attribute that is shown to user
                'model' => 'App\Models\Tuss', // foreign key model
                'limit' => 50,
                'visibleInTable' => false,
                'visibleInModal' => true,
                'visibleInExport' => true,
                'visibleInShow' => true,
            ],
            [
                // n-n relationship (with pivot table)
                'label' => 'CBO', // Table column heading
                'type' => 'select2_multiple',
                'name' => 'cbo', // the method that defines the relationship in your Model
                'entity' => 'cbo', // the method that defines the relationship in your Model
                'attribute' => 'cbo_code_description', // foreign key attribute that is shown to user
                'model' => 'App\Models\Cbo', // foreign key model
                'limit' => 50,
                'visibleInTable' => false,
                'visibleInModal' => true,
                'visibleInExport' => true,
                'visibleInShow' => true,
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
        CRUD::setValidation(ProviderRequest::class);

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

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }


    private function addFields()
    {
        $this->crud->addFields([
            [
                'name' => 'cpf_cnpj',
                'label' => 'CPF/CNPJ (somente números)',
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'attributes' => [
                    'onchange' => "formatCnpjCpf(this)"
                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'name',
                'label' => 'Nome Completo / Razão Social',
                'type' => 'text',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'attributes' => [
                    'onkeyup' => "maiuscula(this)"
                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'email',
                'label' => 'E-Mail',
                'type' => 'email',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'attributes' => [
                    'onkeyup' => "minusculo(this)"
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
//                'data_source' => url('/provider/fetch/city'), // url to controller search function (with /{id} should return model)
                'data_source' => url('/provider/fetch/city'), // url to controller search function (with /{id} should return model)
                'method' => 'POST', // route method, either GET or POST
                'allows_null' => true,
                'placeholder' => 'Selecione o município', // placeholder for the select
                'minimum_input_length' => 2, // minimum characters to type before querying results
                'dependencies' => ['state_id'],
                'include_all_form_fields' => ['state_id'],
//                'tab'                  => 'Selects',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'phone1',
                'label' => 'Telefone 1',
                'type' => 'phone',
                'config' => [
                    'onlyCountries' => ['br'],
//                    'initialCountry' => 'br', // this needs to be in the allowed country list, either in `onlyCountries` or NOT in `excludeCountries`
                    'separateDialCode' => true,
                    'nationalMode' => true,
                    'autoHideDialCode' => false,
                    'placeholderNumberType' => 'MOBILE',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'phone2',
                'label' => 'Telefone 2',
                'type' => 'phone',
                'config' => [
                    'onlyCountries' => ['br'],
                    'initialCountry' => 'br', // this needs to be in the allowed country list, either in `onlyCountries` or NOT in `excludeCountries`
                    'separateDialCode' => true,
                    'nationalMode' => true,
                    'autoHideDialCode' => false,
                    'placeholderNumberType' => 'MOBILE',
                ],
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'tab' => 'Dados Básicos',
            ],
            [
                // radio
                'name' => 'additional_information', // the name of the db column
                'label' => 'Informação complementar', // the input label
                'type' => 'textarea',
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
                'label' => "TUSS",
                'type' => 'select2_multiple',
                'name' => 'tuss', // the method that defines the relationship in your Model
                'entity' => 'tuss', // the method that defines the relationship in your Model
                'model' => "App\Models\Tuss", // foreign key model
                'attribute' => 'tuss_code_description', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'select_all' => true, // show Select All and Clear buttons?
                'options' => (function ($query) {
                    return $query->orderBy('code', 'ASC')->where('status', 1)->get();
                }),
                'tab' => 'TUSS / CBO',
            ],
            [
                'name' => 'cbo',
                'label' => 'CBO', // Table column heading
                'type' => 'relationship',
                'ajax' => true,
                'model' => "App\Models\Cbo", // foreign key model
                'entity' => 'cbo', // the method that defines the relationship in your Model
                'attribute' => 'description', // foreign key attribute that is shown to user
                'data_source' => url('/provider/fetch/cbo'), // url to controller search function (with /{id} should return model)
                'method' => 'POST', // route method, either GET or POST
                'allows_null' => true,
                'multiple' => true,
                'placeholder' => 'Selecione o CBO', // placeholder for the select
                'minimum_input_length' => 0, // minimum characters to type before querying results
                'dependencies' => ['tuss'],
                'include_all_form_fields' => ['tuss'],
                'tab' => 'TUSS / CBO',
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
//                $form = collect(request()->input('form'))->pluck('value', 'name');
                $form = backpack_form_input();

                if (!isset($form['state_id']) || empty($form['state_id'])) {
                    return $model->where('state_id', 0);
                }

                if ($search) {
                    return $model->whereRaw('LOWER(cities.name) LIKE "%' . strtolower($search) . '%"')
                        ->where('state_id', $form['state_id']);
                } else {
                    return $model->where('state_id', $form['state_id']);
                }

            }
        ]);
    }

    protected function fetchCbo()
    {
        return $this->fetch([
            'model' => \App\Models\Cbo::class,
            'searchable_attributes' => [],
            'query' => function ($model) {
                $search = request()->input('q') ?? false;
                $form = backpack_form_input();
                if (!isset($form['tuss']) || empty($form['tuss'])) {
                    return $model->whereIn('tuss_id', []);
                }

                if ($search) {
                    return $model->whereRaw('LOWER(cbo.description) LIKE "%' . strtolower($search) . '%"')
                        ->whereIn('tuss_id', $form['tuss'])
                        ->orderBy('description', 'ASC');
                } else {
                    return $model->whereIn('tuss_id', $form['tuss'])
                        ->orderBy('description', 'ASC');
                }

            }]);
    }
}
