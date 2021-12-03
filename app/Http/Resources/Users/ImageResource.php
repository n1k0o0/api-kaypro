<?php

namespace App\Http\Resources\Users;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property string file_name
 * @property string mime_type
 * @property string name
 * @method getUrl
 **/
class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
                'mime_type' => $this->mime_type,
                'file_name' => $this->file_name,
                'name' => $this->name,
                'url' => $this->getUrl(),
        ];
    }
}
