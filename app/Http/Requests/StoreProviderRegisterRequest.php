<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProviderRegisterRequest extends FormRequest
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
            'nationality' => 'required|string|max:25' ,
            'nat_id' => 'required|string|max:20',
            'phone' => 'required|regex:/^((?:[+?0?0?966]+)(?:\s?\d{2})(?:\s?\d{7}))$/',
            'email' => 'required|email|unique:users,email|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/' ,
            'birthdate' => 'required|date_format:"Y-m-d',
            'user_type' => 'required|in:user,provider',
            'latitude' => 'nullable|max:9' ,
            'longitude' => 'nullable|max:9' ,
            'image'=>'nullable|image:jpeg,jpg,png,gif|max:10000',
            'description'=>'required|string|max:200',
            'min_cost'=> 'required|numeric',
            'delivery_cost'=> 'required|numeric',
            'booking_status'=> 'required|boolean',
            'direct_serv_status'=> 'required|boolean',
            'experience' => 'required|numeric',
            'address_info' => 'required|string|max:200',
            'category_id' => 'required',
            'service' => 'required|array',
            'package' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->returnError($validator->errors()->first()));

    }
}
