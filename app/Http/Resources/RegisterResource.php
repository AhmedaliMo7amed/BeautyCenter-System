<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'city' => $this->city,
            'region' => $this->region,
            'street' => $this->street,
            'floor' => $this->floor,
            'landmark' => $this->landmark,
            'image' => $this->image,
            'created_at' => $this->created_at->format('y-d-m'),
            'updated_at' => $this->updated_at->format('y-d-m'),
        ];
    }
}
