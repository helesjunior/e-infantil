<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers',
], function () { // custom admin routes

    //Fetchs Routes
    Route::post('/provider/fetch/city', '\App\Http\Controllers\Register\ProviderCrudController@fetchCity');
    Route::post('/provider/fetch/cbo', '\App\Http\Controllers\Register\ProviderCrudController@fetchCbo');
    Route::get('/contract/fetch/cbo', '\App\Http\Controllers\Register\ContractCrudController@fetchCbo');

//    Route::group([
//        'prefix' => 'api',
//        'namespace' => 'Api',
//    ], function () {
//        Route::get('city', 'CityController@index');
//        Route::get('city/{id}', 'CityController@show');
//    });

    Route::group([
        'namespace' => 'Admin',
        'prefix' => 'administracao',
        'middleware' => ['web', backpack_middleware()],
    ], function () {
        Route::crud('permissao', 'PermissionCrudController');
        Route::crud('grupo', 'RoleCrudController');
        Route::crud('usuario', 'UserCrudController');
        Route::crud('codigo', 'CodeCrudController');
        Route::crud('codigo/{code}/item', 'CodeItemCrudController');
        Route::crud('tuss', 'TussCrudController');
        Route::crud('cbo', 'CboCrudController');
    });

    Route::group([
        'namespace' => 'Register',
        'prefix' => 'cadastro',
        'middleware' => ['web', backpack_middleware()],
    ], function () {
        Route::crud('prestador', 'ProviderCrudController');
        Route::crud('contrato', 'ContractCrudController');
    });

});
