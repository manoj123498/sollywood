<?php

namespace App\Http\Resources;

use App\Models\Gallery;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
        */
    public function toArray($request): array
    {
        /** @var Gallery|JsonResource $this */

        return [
            'id' => (int) $this->id,
            'title' => (string) $this->title,
            'type' => $this->when($this->type, (string) $this->type),
            'loadable_type' => $this->when($this->loadable_type, (string) $this->loadable_type),
            'loadable_id' => $this->when($this->loadable_id, (int) $this->loadable_id),
            'path' => (string) $this->path,
            'loadable' => $this->whenLoaded('loadable'),
            'base_path' => request()->getHttpHost() . '/storage/images/',
        ];
    }
}
