<?php

namespace App\Models\Footballs;

use App\Services\GetSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_service_id','price','image'
    ];

    public function typeService()
    {
        return $this->belongsTo(TypeService::class, 'type_service_id', 'id');
    }

    public function currentLang()
    {
        return $this->hasOne(ServiceLang::class, 'service_id', 'id')->where('lang', GetSession::getLocale());
    }

    public function serviceLangs()
    {
        return $this->hasMany(ServiceLang::class, 'service_id', 'id');
    }
}
