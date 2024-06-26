<?php

namespace App\Http\Resources;

use App\Models\ShopWorkingDay;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopWorkingDayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ShopWorkingDay|JsonResource $this */
        return [
            'id'            => $this->when($this->id, $this->id),
            'day'           => $this->when($this->day, $this->day),
            'from'          => $this->when($this->from, $this->from),
            'to'            => $this->when($this->to, $this->to),
            'disabled'      => (boolean)$this->disabled,
            'created_at'    => $this->when($this->created_at, optional($this->created_at)->format('Y-m-d H:i:s')),
            'updated_at'    => $this->when($this->updated_at, optional($this->updated_at)->format('Y-m-d H:i:s')),

            'shop'          => ShopResource::make($this->whenLoaded('shop')),
        ];
    }
}
