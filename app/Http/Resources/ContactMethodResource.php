<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactMethodResource extends JsonResource
{
    public function toArray($request)
    {
        /*return parent::toArray($request);*/
        return [
            'name' => $this->name,
        ];
    }
}
