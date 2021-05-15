<?php
namespace App\Services;
use Illuminate\Support\Facades\Session;



class GetSession
{
    public static function getLocale()
    {
        return Session::get('locale');
    }

    public static function getCity()
    {
        return Session::get('city');
    }

    public static function putCity($city)
    {
        Session::put('city', $city);
    }

    public static function putFoodPlaceId($food_place_id)
    {
        Session::put('food_place_id',$food_place_id);
    }

    public static function getFoodPlaceId()
    {
        return  Session::get('food_place_id');

    }
}
