<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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

    public function rules()
    {
        return [
            // User Validation
            'offer_price'=> 'required|numeric',
            'payment' => 'required|in:online,cash',
            'wallet_balance' => 'required|boolean' ,
            'location' => 'required|string|max:200',
            'latitude' => 'nullable|max:9' ,
            'longitude' => 'nullable|max:9' ,
            'used_coupon' => 'sometimes|boolean' ,
            'coupon_id' => 'sometimes|numeric',
            'service' => 'required|array',
        ];
    }
}
