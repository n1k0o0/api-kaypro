<?php

namespace App\Http\Resources\Moderators;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
                'id' => $this->file_name,
                'mime_type' => $this->mime_type,
                'file_name' => $this->file_name,
                'name' => $this->name,
                'url' => $this->getUrl(),
        ];
    }
}
