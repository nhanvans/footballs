<?php
namespace App\Repositories\Providers\Footballs;

use App\Models\Footballs\OpenTime;

class OpenTimeRepository
{
    public function getOpenTimeFirstByFootballPlaceId($footballPlaceId)
    {
        return OpenTime::where('football_place_id',$footballPlaceId)->first();
    }

    public function create($credentials)
    {
        $result = OpenTime::create($credentials);
        return $result;
    }

    public function getOpenTimeById($id)
    {
        return OpenTime::findOrFail($id);
    }

    public function update($credentials,$id)
    {
        $openTime = self::getOpenTimeById($id);
        $openTime->update($credentials);
        return $openTime;
    }

}

