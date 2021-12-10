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
 * @property string meta_h1
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property string meta_slug
 * @property string meta_image
 **/
class NewsResource extends JsonResource
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
            'title' => $this->title,
            'text' => $this->text,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'meta_slug' => $this->meta_slug,
            'meta_image' => $this->meta_image,
            'published_at' => $this->published_at,
            'logo' => ImageResource::make($this->whenLoaded('logo')),
            'banner' => ImageResource::make($this->whenLoaded('banner')),
        ];
    }
}
