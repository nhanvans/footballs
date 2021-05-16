<?php
namespace App\Repositories\Providers\Footballs;

use App\Models\Footballs\SocialNetwork;

class SocialNetWorkRepository
{

    public function getFisrtByFootballPlace($footballPlaceId)
    {
        return SocialNetwork::where('football_place_id', $footballPlaceId)->first();
    }

    public function create($credentials)
    {
        $result = SocialNetwork::create($credentials);
        return $result;
    }

    public function findById($id)
    {
        return SocialNetwork::findOrFail($id);
    }

    public function update($credentials,$id)
    {
        $socialNetwork = self::findById($id);
        $socialNetwork->update($credentials);
        return $socialNetwork;
    }
}

