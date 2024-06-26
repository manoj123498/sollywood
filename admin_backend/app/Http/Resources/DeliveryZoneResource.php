<?php

namespace App\Http\Resources;

use App\Models\Delivery;
use App\Models\DeliveryZone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var DeliveryZone|JsonResource $this */

        return [
            'id'        => $this->id,
            'address'   => $this->address,

            'shop'      => ShopResource::make($this->whenLoaded('shop'))
        ];
    }
}
