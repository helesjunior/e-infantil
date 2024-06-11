<?php
namespace Database\Seeders;

use App\Models\Code;
use App\Models\CodeItem;
use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ************************************************************
        // Regiões
        // ************************************************************
        $codigoLista = Code::create([
            'description' => 'Regiões do País',
            'is_visible' => 0
        ])->id;

        $norte = CodeItem::create([
            'code_id' => $codigoLista,
            'short_description' => 'NORTE',
            'description' => 'Norte'
        ])->id;

        $nordeste = CodeItem::create([
            'code_id' => $codigoLista,
            'short_description' => 'NORDESTE',
            'description' => 'Nordeste'
        ])->id;

        $centroOeste = CodeItem::create([
            'code_id' => $codigoLista,
            'short_description' => 'CENTRO',
            'description' => 'Centro-Oeste'
        ])->id;

        $sudeste = CodeItem::create([
            'code_id' => $codigoLista,
            'short_description' => 'SUDESTE',
            'description' => 'Sudeste'
        ])->id;

        $sul = CodeItem::create([
            'code_id' => $codigoLista,
            'short_description' => 'SUL',
            'description' => 'Sul'
        ])->id;

        // ************************************************************
        // states
        // ************************************************************
        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 12,
            'uf' => 'AC',
            'name' => 'Acre',
            'region_id' => $norte,
            'latitude' => '-8.77',
            'longitude' => '-70.55'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 27,
            'uf' => 'AL',
            'name' => 'Alagoas',
            'region_id' => $nordeste,
            'latitude' => '-9.62',
            'longitude' => '-36.82'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 16,
            'uf' => 'AP',
            'name' => 'Amapá',
            'region_id' => $norte,
            'latitude' => '1.41',
            'longitude' => '-51.77'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 13,
            'uf' => 'AM',
            'name' => 'Amazonas',
            'region_id' => $norte,
            'latitude' => '-3.47',
            'longitude' => '-65.1'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 29,
            'uf' => 'BA',
            'name' => 'Bahia',
            'region_id' => $nordeste,
            'latitude' => '-13.29',
            'longitude' => '-41.71'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 23,
            'uf' => 'CE',
            'name' => 'Ceará',
            'region_id' => $nordeste,
            'latitude' => '-5.2',
            'longitude' => '-39.53'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 53,
            'uf' => 'DF',
            'name' => 'Distrito Federal',
            'region_id' => $centroOeste,
            'latitude' => '-15.83',
            'longitude' => '-47.86'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 32,
            'uf' => 'ES',
            'name' => 'Espírito Santo',
            'region_id' => $sudeste,
            'latitude' => '-19.19',
            'longitude' => '-40.34'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 52,
            'uf' => 'GO',
            'name' => 'Goiás',
            'region_id' => $centroOeste,
            'latitude' => '-15.98',
            'longitude' => '-49.86'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 21,
            'uf' => 'MA',
            'name' => 'Maranhão',
            'region_id' => $nordeste,
            'latitude' => '-5.42',
            'longitude' => '-45.44'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 51,
            'uf' => 'MT',
            'name' => 'Mato Grosso',
            'region_id' => $centroOeste,
            'latitude' => '-12.64',
            'longitude' => '-55.42'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 50,
            'uf' => 'MS',
            'name' => 'Mato Grosso do Sul',
            'region_id' => $centroOeste,
            'latitude' => '-20.51',
            'longitude' => '-54.54'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 31,
            'uf' => 'MG',
            'name' => 'Minas Gerais',
            'region_id' => $sudeste,
            'latitude' => '-18.1',
            'longitude' => '-44.38'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 15,
            'uf' => 'PA',
            'name' => 'Pará',
            'region_id' => $norte,
            'latitude' => '-3.79',
            'longitude' => '-52.48'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 25,
            'uf' => 'PB',
            'name' => 'Paraíba',
            'region_id' => $nordeste,
            'latitude' => '-7.28',
            'longitude' => '-36.72'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 41,
            'uf' => 'PR',
            'name' => 'Paraná',
            'region_id' => $sul,
            'latitude' => '-24.89',
            'longitude' => '-51.55'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 26,
            'uf' => 'PE',
            'name' => 'Pernambuco',
            'region_id' => $nordeste,
            'latitude' => '-8.38',
            'longitude' => '-37.86'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 22,
            'uf' => 'PI',
            'name' => 'Piauí',
            'region_id' => $nordeste,
            'latitude' => '-6.6',
            'longitude' => '-42.28'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 33,
            'uf' => 'RJ',
            'name' => 'Rio de Janeiro',
            'region_id' => $sudeste,
            'latitude' => '-22.25',
            'longitude' => '-42.66'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 24,
            'uf' => 'RN',
            'name' => 'Rio Grande do Norte',
            'region_id' => $nordeste,
            'latitude' => '-5.81',
            'longitude' => '-36.59'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 43,
            'uf' => 'RS',
            'name' => 'Rio Grande do Sul',
            'region_id' => $sul,
            'latitude' => '-30.17',
            'longitude' => '-53.5'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 11,
            'uf' => 'RO',
            'name' => 'Rondônia',
            'region_id' => $norte,
            'latitude' => '-10.83',
            'longitude' => '-63.34'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 14,
            'uf' => 'RR',
            'name' => 'Roraima',
            'region_id' => $norte,
            'latitude' => '1.99',
            'longitude' => '-61.33'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 42,
            'uf' => 'SC',
            'name' => 'Santa Catarina',
            'region_id' => $sul,
            'latitude' => '-27.45',
            'longitude' => '-50.95'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 35,
            'uf' => 'SP',
            'name' => 'São Paulo',
            'region_id' => $sudeste,
            'latitude' => '-22.19',
            'longitude' => '-48.79'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 28,
            'uf' => 'SE',
            'name' => 'Sergipe',
            'region_id' => $nordeste,
            'latitude' => '-10.57',
            'longitude' => '-37.45'
        ]);

        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 17,
            'uf' => 'TO',
            'name' => 'Tocantins',
            'region_id' => $norte,
            'latitude' => '-9.46',
            'longitude' => '-48.26'
        ]);

        // ************************************************************
        // Exceção
        // ************************************************************
        \Illuminate\Support\Facades\DB::table('states')->insert([
            'id' => 99,
            'uf' => 'EX',
            'name' => 'Exterior'
        ]);

    }

}
