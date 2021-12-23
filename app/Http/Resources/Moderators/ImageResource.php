<?php

namespace App\Http\Resources\Moderators;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
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
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'mime_type' => $this->mime_type,
            'file_name' => $this->file_name,
            'name' => $this->name,
            'url' => $this->getUrl(),
        ];
    }
}
