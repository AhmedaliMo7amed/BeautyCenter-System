<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
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
                'id' => $this->id,
                'token' => $this->token,
                'user_type' => $this->user_type,
                'nationality' => $this->nationality,
                'nat_id' => $this->nat_id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'birthdate' => $this->birthdate,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'image' => $this->image,
                'details' => new ProviderDetailsResource($this->providerDetails),
                'categories' => $this->categories,
                'services' => ProviderServicesResource::collection($this->services),
                'packages' => $this->packages,

            ];
    }
}
