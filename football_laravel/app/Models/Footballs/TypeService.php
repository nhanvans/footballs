<?php

namespace App\Models\Footballs;

use App\Services\GetSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeService extends Model
{
    use HasFactory;

    protected $fillable = ['football_place_id'];

    public function services()
    {
        return $this->hasMany(Service::class, 'type_service_id','id');
    }

    public function footballPlace()
    {
        return $this->belongsTo(FootballPlace::class,'football_place_id','id');
    }

    public function currentLang()
    {
        return $this->hasOne(TypeServiceLang::class, 'type_service_id', 'id')->where('lang', GetSession::getLocale());
    }

    public function typeServiceLangs()
    {
        return $this->hasMany(TypeServiceLang::class, 'type_service_id', 'id');
    }
}
