<?php
namespace App\Repositories\Providers\Footballs;

use App\Models\Footballs\Service;
use App\Models\Footballs\ServiceLang;
use App\Models\Footballs\TypeService;
use App\Models\Footballs\TypeServiceLang;
use App\Services\GetSession;
use Illuminate\Support\Facades\File;
use Image;

class ServiceRepository
{

    public function getAllTypeServiceByFootballPlaceId($footballPlaceId)
    {
        return TypeService::with(['services','typeServiceLangs','currentLang','services.serviceLangs','services.currentLang'])
            ->where('football_place_id', $footballPlaceId)->get();

    }

    public function createMenu($request)
    {
        $footballPlaceId = $request->football_place_id;
        $current_lang = GetSession::getLocale();
        if(isset($request->new))
        {
            foreach ($request->new as $new_value)
            {
                $typeService = TypeService::create([
                    'football_place_id' => $footballPlaceId,
                ]);
                TypeServiceLang::create([
                    'type_service_id' => $typeService->id,
                    'name' => $new_value['category_name'],
                    'lang' => $current_lang
                ]);
                $n = 0;
                if(isset($new_value['food']['new']))
                {
                    foreach ($new_value['food']['new'] as $new_food)
                    {
                        $this->createFood($new_food, $typeService->id, $footballPlaceId, $n,$current_lang);
                        $n++;
                    }
                }
                if(isset($new_value['food']['old']))
                {
                    $this->updateOldFood($new_value, $typeService, $footballPlaceId, $n,$current_lang);
                }
            }
        }
        if(isset($request->old))
        {
            foreach($request->old as $key => $old_value)
            {
                $typeService = TypeService::find($key);
                isset($typeService->currentLang) ?
                    $typeService->currentLang->update(['category_name' => $old_value['category_name']]) :
                    TypeServiceLang::create([
                        'food_category_id' => $typeService->id,
                        'category_name' => $old_value['category_name'],
                        'lang' => $current_lang
                    ]);
                $n = 0;
                if(isset($old_value['food'])){
                    $this->updateOldFood($old_value, $typeService, $footballPlaceId, $n,$current_lang);
                    if(isset($old_value['food']['new']))
                    {
                        foreach($old_value['food']['new'] as $new_food)
                        {
                            $this->createFood($new_food, $typeService->id, $footballPlaceId, $n,$current_lang);
                            $n++;
                        }
                    }
                }
            }
        }
        return 'success';
    }

    public function updateOldFood($data, $category, $food_place_id, $n,$current_lang)
    {
        $image_valid_extensions = ['jpg','png','jpeg', 'JPG', 'JPEG', 'PNG', 'jfif'];
        if(isset($data['food']['old'])){
            foreach($data['food']['old'] as $food_id => $old_food)
            {
                $n++;
                $food = Service::find($food_id);
                if($food)
                {
                    $time = $n.'a'.time();
                    if($old_food['image'] != 'undefined' && in_array($old_food['image']->getClientOriginalExtension(),$image_valid_extensions))
                    {
                        $s3_key = 'images/foods/'.$food_place_id.'/'.$category->id.'/'.$time.'.'.$old_food['image']->getClientOriginalExtension();
                        if($food->image != '' && $old_food['move'] == 'true'){
                            UploadFileToS3::delete($food->image);
                        }elseif($food->image != '' && $old_food['move'] == 'false') {
                            $s3_key = $food->image;
                        }
                        UploadFileToS3::uploadImage($old_food['image'], $s3_key);
                    }else {
                        if($food->image != '' && $old_food['move'] == 'true')
                        {
                            $s3_key = 'images/foods/'.$food_place_id.'/'.$category->id.'/'.$time.substr($food->image, strrpos($food->image, '.'));
                            UploadFileToS3::copyToNewKeyAndDelete($s3_key, $food->image);
                        }else {
                            $s3_key = $food->image;
                        }
                    }
                    $food->update([
                        'food_category_id' => $category->id,
                        'price' => $old_food['price'],
                        'image' => $s3_key
                    ]);
                    isset($food->currentLang) ?
                        $food->currentLang->update(['food_name' => $old_food['name']]) :
                        ServiceLang::create([
                            'food_drink_id' => $food->id,
                            'food_name' => $old_food['name'],
                            'lang' => $current_lang
                        ]);
                }
            }
        }
    }

    public function createFood($data,$typeServiceid,$footballPlaceId,$n,$current_lang)
    {
        $s3_key = '';
        $image_valid_extensions = ['jpg','png','jpeg', 'JPG', 'JPEG', 'PNG', 'jfif'];
        if($data['image'] != 'undefined' && in_array($data['image']->getClientOriginalExtension(),$image_valid_extensions))
        {
            $time = $n.'a'.time();
            $s3_key = 'images/footballs/'.$footballPlaceId.'/'.$typeServiceid.'/'.$time.'.'.$data['image']->getClientOriginalExtension();
            $dir = 'images/footballs/'.$footballPlaceId.'/'.$typeServiceid.'/';
            $baseDir = public_path().'/';
            !File::exists($baseDir.$dir) ? mkdir($baseDir.$dir, 0777, true) : null;
            Image::make($data['image'])->save($s3_key);
        }
        $services = Service::create([
            'type_service_id' => $typeServiceid,
            'price' => $data['price'],
            'image' => $s3_key
        ]);
        ServiceLang::create([
            'service_id' => $services->id,
            'name' => $data['name'],
            'lang' => $current_lang
        ]);
    }

    public function delete($request)
    {
        if($request->type == 'service')
        {
            $service = Service::find($request->id);
            $this->deleteService($service);
        }else {
            $typeService = TypeService::find($request->id);
            foreach($typeService->services as $service)
            {
                $this->deleteService($service);
            }
            $typeService->delete();
        }
    }

    public function deleteService($service)
    {
        if($service->image != '')
        {
            @unlink($service->image);
        }
        $service->delete();
    }

}

