<?php

namespace App\Models\Footballs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLang extends Model
{
    use HasFactory;

    protected $fillable = [	'detail_id', 'description', 'recommendations', 'lang' ];


}
