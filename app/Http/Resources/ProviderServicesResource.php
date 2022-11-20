<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderServicesResource extends JsonResource
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
            'service_id' => $this->service_id,
            'name' => $this->service->name,
            'image' => $this->service->image,
            'price' => $this->price,
            'time' => $this->time,
            'experience' => $this->experience,
            'description' => $this->description,
            'course_certificate' => $this->course_certificate,
            'experience_certificate' => $this->experience_certificate,
        ];
    }
}
