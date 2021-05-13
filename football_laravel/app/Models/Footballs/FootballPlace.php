<?php

namespace App\Models\Footballs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FootballPlace extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','name','phone','email','website','utilities','max_price','min_price','allow_view'];
}
