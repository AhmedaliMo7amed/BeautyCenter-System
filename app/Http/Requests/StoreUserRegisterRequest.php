<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRegisterRequest extends FormRequest
{

    use GeneralTrait;

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            // User Validation
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:50' ,
            'phone' => 'required|regex:/^((?:[+?0?0?966]+)(?:\s?\d{2})(?:\s?\d{7}))$/',
            'email' => 'required|email|unique:users,email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/' ,
            'birthdate' => 'required|date_format:"Y-m-d',
            'user_type' => 'sometimes|in:user,provider',
            'latitude' => 'nullable|max:9' ,
            'longitude' => 'nullable|max:9' ,
            'image'=>'nullable|image:jpeg,jpg,png,gif|max:10000',
            'city'=>'required|max:20',
            'region'=> 'required|max:20',
            'street'=> 'required|max:50',
            'floor'=> 'required|integer|max:9',
            'land_mark'=> 'nullable|string|max:50',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->returnError($validator->errors()->first()));

    }
}
