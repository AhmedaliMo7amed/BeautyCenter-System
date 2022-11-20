<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'birthdate' => $this->birthdate,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'image' => $this->image,
                'address' => new UserAddressResource($this->address),
            ];


    }
}
