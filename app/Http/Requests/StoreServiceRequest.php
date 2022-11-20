<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreServiceRequest extends FormRequest
{
    use GeneralTrait;
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
        'parent_id'=> 'sometimes|numeric',
        'name' =>'required|unique:categories,name|regex:/^[\pL\s\-]+$/u|max:50',
        'image' => 'nullable|image:jpeg,jpg,png,gif|max:10000',
        ];

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->returnError($validator->errors()->first()));

    }
}
