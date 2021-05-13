<?php

namespace App\Repositories\Providers\Footballs;

use App\Models\Footballs\FootballPlace;
use App\Services\Helper;

class FootballPlaceRepository
{
    public function getFootballPlaceById($id)
    {
        return FootballPlace::findOrFail($id);
    }

    public function getFootballPlaceByUserId($user_id)
    {
        return FootballPlace::where('user_id', $user_id)->first();
    }

    public function getAllFootballPlace()
    {
        return FootballPlace::all();
    }

    public function createFootballPlace($credentials)
    {
        $credentials['name_without_accent'] = isset($credentials['name']) ? str_replace('_',' ', Helper::strToSlugWithUnderScoreAndMb($credentials['name'])) : null;
        $footballPlace = FootballPlace::create($credentials);
        return $footballPlace;
    }

    public function updateFootballPlace($credentials, $id)
    {
        $credentials['name_without_accent'] = isset($credentials['name']) ? str_replace('_',' ', Helper::strToSlugWithUnderScoreAndMb($credentials['name'])) : null;
        $footballPlace = self::getFootballPlaceById($id);
        $status = $footballPlace->status != 0 ? 2 : 0;
        $footballPlace->update(array_merge($credentials,['status' => $status]));
        return $footballPlace;
    }

    public function delete($id)
    {
        $footballPlace = FootballPlace::find($id);
        $footballPlace->delete();
        return $footballPlace;
    }

}

?>
