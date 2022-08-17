<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class FootballPlaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = isset($this->football) ? ','.$this->football.',' : '';
        return [
            'name' => 'required|unique:football_places,name'.$id.'|max:255',
            'phone' => 'required',
            'website' => 'required',
            'email' => 'required',
            'max_price' => 'required|gte:min_price',
            'min_price' => 'required|lte:max_price',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        // throw (new ValidationException($validator))
        //             ->errorBag($this->errorBag)
        //             ->redirectTo($this->getRedirectUrl());
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json([
                "success" => false,
                "status" => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                "message" => @trans('foods.basic-infos.create_fails'),
                'errors' => $errors,
                "data" => [
                ]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
