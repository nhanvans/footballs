<?php

namespace App\Models\Footballs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeServiceLang extends Model
{
    use HasFactory;

    protected $fillable = ['type_service_id','name','lang'];

    public function typeService()
    {
        return $this->belongsTo(TypeService::class, 'type_service_id','id');
    }
}
