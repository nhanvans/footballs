<?php

namespace App\Models\Footballs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id','name','lang'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
