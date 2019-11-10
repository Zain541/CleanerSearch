<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CleanerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /*return parent::toArray($request);*/
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'username' => $this->username,
            'company_name' => $this->company_name,
            'speciality_other' => $this->speciality_other,
            'tracking' => $this->tracking,
            'availability' => $this->availability,
            'specialities' => new SpecialityResource($this->whenLoaded('specialities')),
        ];
    }
}
