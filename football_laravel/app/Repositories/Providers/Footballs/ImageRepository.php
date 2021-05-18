<?php
namespace App\Repositories\Providers\Footballs;

use App\Models\Footballs\Image;
use Illuminate\Support\Facades\File;
use Image as Images;

class ImageRepository
{

    public function createAndUpdate($request, $food_image_id)
    {
        $stringName = '';
        $datas = [];
        $footballPlaceId = $request->football_place_id;
        $footBallImage = self::getImageByIdOrFootballPlaceId($food_image_id, $footballPlaceId);
        if ($request->hasFile('avatar')) {
            $datas['avatar'] = $this->uploadImage($request->file('avatar'), $footballPlaceId, 0, 'avatar/');
        }
        if ($request->hasFile('images')) {
            $stringName = $this->forEachFile($request, $footballPlaceId, $stringName, 'images');
            $datas['images'] = ($footBallImage && $footBallImage->images != '') ? $footBallImage->images.','.$stringName : $stringName;
        }
        if ($footBallImage) {
            $oldLinkAvatar = $footBallImage->avatar;
            $footBallImage->update($datas);
            if(array_key_exists('avatar', $datas) && !empty($oldLinkAvatar)){
               @unlink($oldLinkAvatar);
            }
        }else {
            $datas['football_place_id'] = $footballPlaceId;
            $footBallImage = Image::create($datas);
        }

        return [
            'image_id' => $footBallImage->id,
            'link' => $stringName
        ];
    }

    public function uploadImage($file, $footballPlaceId, $count ,$avatar = '')
    {
        $file_name = '';
        $dir = 'upload/images/foolballs/'.$footballPlaceId.'/'.$avatar;
        $extension = $file->getClientOriginalExtension();
        $image_valid_extensions = ['jpg','png','jpeg', 'JPG', 'JPEG', 'PNG', 'jfif'];
        $baseDir = public_path().'/';
        !File::exists($baseDir.$dir) ? mkdir($baseDir.$dir, 0777, true) : null;
        if(in_array($extension, $image_valid_extensions)){
            $file_name = $dir.'image'.time().$count.'.'.$extension;
            Images::make($file)->save($file_name);

        }

        return $file_name;
    }

    public function forEachFile($request, $footballPlaceId, $stringName, $input_name)
    {
        foreach ($request->file($input_name) as $index=>$image) {
            $stringName .= ','.$this->uploadImage($image, $footballPlaceId, $index);
        }

        return ltrim($stringName, ',');
    }

    public function delete($request, $id)
    {
        $image = $request->image;
        $footBallImage = self::getImageByIdOrFootballPlaceId($id, null);
        $result = false;
        if($footBallImage->images != ''){
            $images = explode(',', $footBallImage->images);
            if(in_array($image, $images)){
                $key = array_search($image, $images);
                unset($images[$key]);
                $footBallImage->images = implode(',', $images);
                $footBallImage->update();
                $result = @unlink($image);
            }
        }
        return ($result != false) ? $result['@metadata']['statusCode']: $result;
    }

    public static function getImageByIdOrFootballPlaceId($imageId, $footballPlaceId)
    {
        return Image::when($imageId != null, function($query) use ($imageId){
            $query->where('id', $imageId);
        }, function($query) use ($footballPlaceId){
            $query->where('football_place_id', $footballPlaceId);
        })->first();
    }
}

