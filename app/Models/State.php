<?php

namespace App\Models;

use App\Models\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'states';
    protected $guarded = ['id'];


    public function region()
    {
        return $this->belongsTo(CodeItem::class,'region_id');
    }

    public function getUfNameAttribute($value)
    {
        return $this->uf . ' - ' . $this->name;
    }
}
