<?php

namespace App\Models\Footballs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GetSession;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [	'football_place_id', 'types', 'operation_times', 'prices', 'amenities', 'capacity',
        'last_admission_time', 'preparation_time', 'holiday'];

    public function detailLangs()
    {
        return $this->hasMany(DetailLang::class, 'detail_id', 'id');
    }

    public function currentLang()
    {
        return $this->hasOne(DetailLang::class, 'detail_id', 'id')->where('lang', GetSession::getLocale());
    }
}
