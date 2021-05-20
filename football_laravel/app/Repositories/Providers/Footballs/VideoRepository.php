<?php
namespace App\Repositories\Providers\Footballs;

use App\Models\Footballs\Video;
use Illuminate\Support\Facades\File;
use Image;

class VideoRepository
{

    public function createAndUpdate($request, $videoId)
    {
        $stringName = '';
        $datas = [];
        $footballPlaceId = $request->football_place_id;
        $footBallVideo = self::getVideoByIdOrFootballPlaceId($videoId, $footballPlaceId);
        if ($request->hasFile('file')) {
            $stringName = $this->upload($footballPlaceId, $request->file('file'));
            $datas['src'] = ($footBallVideo && $footBallVideo->src != '') ? $footBallVideo->src .','. $stringName : $stringName;
        }

        if ($footBallVideo) {
            $footBallVideo->update($datas);
        }else {
            $datas['football_place_id'] = $footballPlaceId;
            $footBallVideo = Video::create($datas);
        }


        return [
            'video_id' => $footBallVideo->id,
            'link' => $stringName
        ];
    }

    public function delete($request, $videoId)
    {
        $footBallVideo = self::getVideoByIdOrFootballPlaceId($videoId, null);
        $link = $request->link;
        $result = false;
        if($footBallVideo){
            $srcs = explode(',', $footBallVideo->src);
            if(in_array($link, $srcs)){
                $key = array_search($link, $srcs);
                unset($srcs[$key]);
                $footBallVideo->src = implode(',', $srcs);
                $footBallVideo->update();
                $result = unlink($link);
            }
        }
        return $result;
    }


    public function upload($footballPlaceId, $file)
    {
        $baseDir = public_path().'/';
        $dir = 'upload/videos/foolballs/'.$footballPlaceId.'/';
        $extension = $file->getClientOriginalExtension();
        $file_name = $dir.'video'.time().rand(0,500).'.'.$extension;
        !File::exists($baseDir.$dir) ? mkdir($baseDir.$dir, 0777, true) : null;
//        UploadFileToS3::uploadFile($file, $file_name);
        Image::make($file)->save($file_name);
        return $file_name;
    }


    public static function getVideoByIdOrFootballPlaceId($videoId, $footballPlaceId)
    {
        return Video::when($videoId != null, function($query) use ($videoId){
            $query->where('id', $videoId);
        })
            ->when(($videoId == null && $footballPlaceId != null), function($query) use ($footballPlaceId){
                $query->where('football_place_id', $footballPlaceId);
            })->first();
    }

}

