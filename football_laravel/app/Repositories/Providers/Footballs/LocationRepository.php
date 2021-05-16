<?php
namespace App\Repositories\Providers\Footballs;

use App\Models\Footballs\Location;

class LocationRepository
{

    public function getFisrtByFootballPlace($footballPlaceId)
    {
        return Location::where('football_place_id', $footballPlaceId)->first();
    }

    public function create($credentials)
    {
        $result = Location::create($credentials);
        return $result;
    }

    public function findById($id)
    {
        return Location::findOrFail($id);
    }

    public function update($credentials,$id)
    {
        $location = self::findById($id);
        $location->update($credentials);
        return $location;
    }
}

