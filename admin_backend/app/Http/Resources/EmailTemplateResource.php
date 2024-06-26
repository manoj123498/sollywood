<?php

namespace App\Http\Resources;

use App\Models\EmailTemplate;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailTemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var EmailTemplate|JsonResource $this */

        return [
            'id'                => $this->id,
            'email_setting_id'  => $this->email_setting_id,
            'subject'           => $this->subject,
            'body'              => $this->body,
            'alt_body'          => $this->alt_body,
            'send_to'           => $this->when($this->send_to, date('Y-m-d H:00:00', strtotime($this->send_to))),
            'created_at'        => $this->when($this->created_at, optional($this->created_at)->format('Y-m-d H:i:s')),
            'updated_at'        => $this->when($this->updated_at, optional($this->updated_at)->format('Y-m-d H:i:s')),

            'email_setting'     => EmailSettingResource::make($this->whenLoaded('emailSetting')),
        ];
    }
}
