<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreJoinCategoryRequest extends FormRequest
{
    use GeneralTrait;
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'category_id.*' => 'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->returnError($validator->errors()->first()));

    }
}
