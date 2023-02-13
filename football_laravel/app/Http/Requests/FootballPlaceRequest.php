<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

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
//        $id = isset($this->football) ? ','.$this->football.',' : '';
        return [
            'name' => [
                'required',
//                'unique:football_places,name'.$id.'',
                'max:255',
                Rule::unique('football_places', 'name')->ignore(isset($this->football) ? $this->football : null)
            ],
            'phone' => 'required|regex:/\+.[0-9]{9,13}/|max:13',
            'website' => 'nullable|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'max_price' => 'required|numeric|gte:min_price|max:2147483647',
            'min_price' => 'required|numeric|max:2147483647',
            'allow_view' => 'nullable|numeric',
            'status'=>'nullable|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
//            'title.required' => 'A title is required',
//            'max_price.gte' => 'The :attribute must be greater than :value.',
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
