<?php

namespace App\Models;

use App\Models\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'cities';
    protected $guarded = ['id'];

    protected $fillable = [
        'code_ibge',
        'name',
        'latitude',
        'longitude',
        'capital',
        'state_id'
    ];


    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
