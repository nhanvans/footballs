<?php
namespace App\Repositories\Providers\Footballs;

use App\Models\Footballs\Detail;
use App\Models\Footballs\DetailLang;

class DetailRepository
{
    public function createAndUpdate($request, $detail_id)
    {
        $datas = [];
        $football_place_id = $request->football_place_id ;
        $lang = $request->lang;
        $datas['types'] = $request->types ? implode(',', $request->types) : '';;
        $datas['operation_times'] = $request->operation_times ? implode(',', $request->operation_times) : '';
        $datas['prices'] = $request->prices ? implode(',', $request->prices) : '';
        $datas['amenities'] = $request->amenities ? implode(',', $request->amenities) : '';
        $datas['capacity'] = $request->capacity;
        $datas['last_admission_time'] = $request->last_admission_time ;
        $datas['preparation_time'] = $request->preparation_time ;
        $datas['holiday'] = $request->holiday ;
        $detail = self::getDetailByIdOrFootballPlaceId($detail_id, $football_place_id);
        if ($detail) {
            $detail->update($datas);
            $detailLang = DetailLang::where('detail_id', $detail_id)->where('lang', $lang)->first();
            if(isset($detailLang))
            {
                $detailLang->update(['description' => $request->description]);
            }else {
                $this->createDetailLangByDetailId($request, $detail->id);
            }
        }else {
            $datas['football_place_id'] = $football_place_id;
            $detail = Detail::create($datas);
            $this->createDetailLangByDetailId($request, $detail->id);
        }
        return $detail;
    }

    public static function getDetailByIdOrFootballPlaceId($detail_id, $football_place_id)
    {
        return Detail::with('currentLang')->when($detail_id != null, function($query) use ($detail_id){
            $query->where('id', $detail_id);
        }, function($query) use ($football_place_id){
            $query->where('football_place_id', $football_place_id);
        })->first();
    }

    public function createDetailLangByDetailId($request, $detail_id)
    {
        DetailLang::create([
            'detail_id' => $detail_id,
            'description' => $request->description,
            'lang' =>  $request->lang,
        ]);
    }

}

