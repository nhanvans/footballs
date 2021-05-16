<?php

namespace App\Models\Footballs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'football_place_id',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
        'zalo',
        'lotus'
    ];
//    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function footballPlace()
    {
        return $this->belongsTo(FootballPlace::class,'football_place_id','id');
    }
}
