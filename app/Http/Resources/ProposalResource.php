<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return 
        [
            'proposal_id' => $this->id,
            'cost' => $this->cost,
            'cleaner' => new CleanerResource($this->whenLoaded('cleaner')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'order' => new OrderResource($this->whenLoaded('order')),
            'status' => new OrderStatusResource($this->whenLoaded('status')),
        ];
    }
}
