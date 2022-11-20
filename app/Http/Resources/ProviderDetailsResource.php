<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'description' => $this->description,
            'min_cost' => $this->min_cost,
            'delivery_cost' => $this->delivery_cost,
            'booking_status' => $this->booking_status,
            'direct_serv_status' => $this->direct_serv_status,
            'experience' => $this->experience,
            'avg_rate' => $this->avg_rate,
            'address_info' => $this->address_info,
        ];
    }
}
