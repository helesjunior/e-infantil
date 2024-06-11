<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Operations\FetchOperation;
use App\Http\Requests\ContractRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContractCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContractCrudController extends CrudController
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
        if (!backpack_user()->can('cadastro_contratos_acesso')) {
            abort('403', config('app.erro_permissao'));
        }

        CRUD::setModel(\App\Models\Contract::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cadastro/contrato');
        CRUD::setEntityNameStrings('contrato', 'contratos');

        // deny access according to configuration file
        if (!backpack_user()->can('cadastro_contratos_criar')) {
            $this->crud->denyAccess('create');
        }
        if (!backpack_user()->can('cadastro_contratos_editar')) {
            $this->crud->denyAccess('update');
        }
        if (!backpack_user()->can('cadastro_contratos_deletar')) {
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
                'name' => 'number',
                'label' => 'Número contrato',
                'type' => 'text',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                // run a function on the CRUD model and show its return value
                'name' => 'provider_id',
                'label' => 'Prestador principal', // Table column heading
                'type' => 'model_function',
                'function_name' => 'getProviderCpfCnpjName', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                 'limit' => 100, // Limit the number of characters shown
                // 'escaped' => false, // echo using {!! !!} instead of {{ }}, in order to render HTML
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                // n-n relationship (with pivot table)
                'label' => 'Demais prestadores vinculados', // Table column heading
                'type' => 'select2_multiple',
                'name' => 'othersProviders', // the method that defines the relationship in your Model
                'entity' => 'othersProviders', // the method that defines the relationship in your Model
                'attribute' => 'cpf_cnpj_name', // foreign key attribute that is shown to user
                'model' => 'App\Models\Provider', // foreign key model
                'limit' => 100,
                'visibleInTable' => false,
                'visibleInModal' => true,
                'visibleInExport' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'signature_date',
                'label' => 'Data assinatura',
                'type' => 'date',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'beginning_date_term',
                'label' => 'Data vigência início',
                'type' => 'date',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'end_date_term',
                'label' => 'Data vigência fim',
                'type' => 'date',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'object',
                'label' => 'Objeto',
                'type' => 'textarea',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'readjustment',
                'label' => 'Condições reajuste',
                'type' => 'text',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name' => 'last_terms',
                'label' => 'Termos',
                'type' => 'text',
                'visibleInTable' => true,
                'visibleInModal' => true,
                'visibleInShow' => true,
            ],
            [
                'name'      => 'items',
                'label'     => 'Itens do contrato',
                'type'      => 'repeatable',
                'subfields' => [
                    [
                        // n-n relationship (with pivot table)
                        'label' => 'TUSS', // Table column heading
                        'type' => 'model_function',
                        'name' => 'tuss', // the method that defines the relationship in your Model
                        'function_name' => 'getTuss', // the method that defines the relationship in your Model
                        'limit' => 50,
                        'wrapper' => [
                            'class' => 'col-md-4',
                        ],
                        'visibleInTable' => false,
                        'visibleInModal' => true,
                        'visibleInExport' => true,
                        'visibleInShow' => true,
                    ],
                    [
                        // n-n relationship (with pivot table)
                        'label' => 'CBO', // Table column heading
                        'type' => 'model_function',
                        'name' => 'cbo', // the method that defines the relationship in your Model
                        'function_name' => 'getCbo', // the method that defines the relationship in your Model
                        'limit' => 50,
                        'wrapper' => [
                            'class' => 'col-md-4',
                        ],
                        'visibleInTable' => false,
                        'visibleInModal' => true,
                        'visibleInExport' => true,
                        'visibleInShow' => true,
                    ],
                    [
                        'name'    => 'price',
                        'type'    => 'number',
                        'label'   => 'Valor',
                        'decimals'      => 2,
                        'dec_point'     => ',',
                        'thousands_sep' => '.',
                        'wrapper' => [
                            'class' => 'col-md-3',
                        ],
                    ],
                ],
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
        CRUD::setValidation(ContractRequest::class);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    private function addFields()
    {
        $this->crud->addFields([
            [
                'name' => 'number',
                'label' => 'Número contrato',
                'type' => 'contractnumber',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
//                'attributes' => [
//                    'onchange' => "formatCnpjCpf(this)"
//                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'provider_id',
                'label' => 'Prestador principal',
                'type' => 'select2',
                'entity' => 'provider', // the method that defines the relationship in your Model
                'model' => "App\Models\Provider", // foreign key model
                'attribute' => 'cpf_cnpj_name', // foreign key attribute that is shown to user
                'allows_null' => true,
                'placeholder' => "Selecione o prestador",
//                'default'   => 2, // set the default value of the select2
                // also optional
                'options' => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
                'wrapperAttributes' => ['class' => 'form-group col-md-8'],
                'tab' => 'Dados Básicos',
            ],
            [
                'label' => "Demais prestadores vinculados",
                'type' => 'select2_multiple',
                'name' => 'othersProviders', // the method that defines the relationship in your Model
                'entity' => 'othersProviders', // the method that defines the relationship in your Model
                'model' => "App\Models\Provider", // foreign key model
                'attribute' => 'cpf_cnpj_name', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'select_all' => true, // show Select All and Clear buttons?
                'options' => (function ($query) {
                    return $query->orderBy('name', 'ASC')->where('status', 1)->get();
                }),
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'signature_date',
                'label' => 'Data assinatura',
                'type' => 'date',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
//                'attributes' => [
//                    'onkeyup' => "maiuscula(this)"
//                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'beginning_date_term',
                'label' => 'Data vigência início',
                'type' => 'date',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
//                'attributes' => [
//                    'onkeyup' => "maiuscula(this)"
//                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'end_date_term',
                'label' => 'Data vigência fim',
                'type' => 'date',
                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
//                'attributes' => [
//                    'onkeyup' => "maiuscula(this)"
//                ],
                'tab' => 'Dados Básicos',
            ],
            [
                // radio
                'name' => 'object', // the name of the db column
                'label' => 'Objeto', // the input label
                'type' => 'textarea',
                'attributes' => [
                    'onkeyup' => "maiuscula(this)"
                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'readjustment',
                'label' => 'Condições reajuste',
                'type' => 'text',
//                'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                'attributes' => [
                    'onkeyup' => "maiuscula(this)"
                ],
                'tab' => 'Dados Básicos',
            ],
            [
                'name' => 'last_terms',
                'label' => 'Termos',
                'type' => 'text',
//                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
                'attributes' => [
                    'onkeyup' => "maiuscula(this)"
                ],
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
            [   // repeatable
                'name' => 'items',
                'label' => 'Itens do Contrato',
                'type' => 'repeatable',
                'subfields' => [ // also works as: "fields"
                    [
                        'label' => "TUSS",
                        'type' => 'select2',
                        'name' => 'tuss', // the method that defines the relationship in your Model
                        'entity' => 'tuss', // the method that defines the relationship in your Model
                        'model' => "App\Models\Tuss", // foreign key model
                        'attribute' => 'tuss_code_description', // foreign key attribute that is shown to user
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                        'select_all' => true, // show Select All and Clear buttons?
                        'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                        'options' => (function ($query) {
                            return $query->orderBy('code', 'ASC')->where('status', 1)->get();
                        }),
                    ],
                    [
                        'label' => "CBO",
                        'type' => 'select2',
                        'name' => 'cbo', // the method that defines the relationship in your Model
                        'entity' => 'cbo', // the method that defines the relationship in your Model
                        'model' => "App\Models\Cbo", // foreign key model
                        'attribute' => 'cbo_code_description', // foreign key attribute that is shown to user
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                        'select_all' => true, // show Select All and Clear buttons?
                        'wrapperAttributes' => ['class' => 'form-group col-md-4'],
                        'options' => (function ($query) {
                            return $query->orderBy('code', 'ASC')->where('status', 1)->get();
                        }),
                    ],
                    [
                        'name' => 'price',
                        'type' => 'number',
                        'label' => 'Valor',
                        'attributes' => ["step" => 'any'],
                        'wrapper' => ['class' => 'form-group col-md-4'],
                    ]
                ],
                'reorder' => false, // hide up&down arrows next to each row (no reordering)
                'tab' => 'Itens',
            ],
        ]);
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
