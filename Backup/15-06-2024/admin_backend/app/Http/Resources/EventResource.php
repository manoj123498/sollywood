<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'cashback_amount' => $this->cashback_amount,
            'event_start_date' => $this->event_start_date,
            'event_end_date' => $this->event_end_date,
        ];
    }
}
