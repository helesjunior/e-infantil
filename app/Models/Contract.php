<?php

namespace App\Models;

use App\Models\Traits\LogsActivity;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use CrudTrait;
    use HasFactory;
    use LogsActivity;
    use softDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'contracts';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'number',
        'provider_id',
        'signature_date',
        'beginning_date_term',
        'end_date_term',
        'object',
        'readjustment',
        'last_terms',
        'status'
    ];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getProviderCpfCnpjName()
    {
        return $this->provider->cpf_cnpj_name;
    }



    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function othersProviders()
    {
        return $this->belongsToMany(Provider::class, 'contract_provider', 'contract_id', 'provider_id');
    }

    public function items()
    {
        return $this->hasMany(ContractItem::class, 'contract_id');
    }




    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
