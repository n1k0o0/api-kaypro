<?php

namespace App\Http\Resources\Users\News;

use App\Http\Resources\Users\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int id
 * @property string title
 * @property string text
 * @property string published_at
 **/
class NewsResource extends JsonResource
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
                'id' => $this->id,
                'title' => $this->title,
                'text' => $this->text,
                'published_at' => $this->published_at,
                'logo' => ImageResource::make($this->whenLoaded('logo')),
        ];
    }
}
