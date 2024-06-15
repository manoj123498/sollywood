<?php

namespace App\Http\Resources;

use App\Models\Birthday;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BirthdayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Birthday|JsonResource $this */

        return [
            'gift_amount' => $this->gift_amount,
        ];
    }
}
