<?php

namespace App\Http\Resources;

// use App\Http\Resources\CustomerResource;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'post_code' => $this->post_code,
            'address' => $this->address,
            'alternative_address' => $this->alternative_address,
            'property_type' => $this->property_type,
            'contract_type' => $this->contract_type,
            'no_of_bedrooms' => $this->no_of_bedrooms,
            'phone_number' => $this->phone_number,
            'no_of_bathrooms' => $this->no_of_bathrooms,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'contactMethods' => ContactMethodResource::collection($this->whenLoaded('contactMethods')),
            'propertyType' => new PropertyTypeResource($this->whenLoaded('propertyType')),

            'contractType' => new ContractTypeResource($this->whenLoaded('contractType')),
            

        ];
    }
}
