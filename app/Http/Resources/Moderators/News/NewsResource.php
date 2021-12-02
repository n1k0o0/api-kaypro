<?php

namespace App\Http\Resources\Moderators\News;

use App\Http\Resources\Moderators\ImageResource;
use App\Http\Resources\Moderators\Moderator\ModeratorResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class NewsResource extends JsonResource
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
                'id' => $this->id,
                'title' => $this->title,
                'text' => $this->text,
                'moderator_id' => $this->moderator_id,
                'published_at' => $this->published_at,
                'visibility' => (int)$this->visibility,
                'author' => ModeratorResource::make($this->whenLoaded('author')),
                'logo' => ImageResource::make($this->whenLoaded('logo')),
        ];
    }
}
