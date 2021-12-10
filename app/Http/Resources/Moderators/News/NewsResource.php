<?php

namespace App\Http\Resources\Moderators\News;

use App\Http\Resources\Moderators\ImageResource;
use App\Http\Resources\Moderators\Moderator\ModeratorResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property int id
 * @property string title
 * @property string text
 * @property string published_at
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property string meta_slug
 * @property string meta_image
 * @property int moderator_id
 * @property bool visibility
 **/
class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
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
            'moderator_id' => $this->moderator_id,
            'visibility' => (int)$this->visibility,
            'author' => ModeratorResource::make($this->whenLoaded('author')),
        ];
    }
}
