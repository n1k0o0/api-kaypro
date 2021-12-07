<?php

namespace App\Http\Resources\Users\Page;

use App\Http\Resources\Users\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property int id
 * @property string name
 * @property string meta_h1
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property object content
 * @property object banner
 * @property object contentImage1
 * @property object contentImage2
 **/
class PageResource extends JsonResource
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
            'name' => $this->name,
            'meta_h1' => $this->meta_h1,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'content' => $this->content,
            'banner' => $this->when((bool)$this->banner, ImageResource::make($this->banner)),
            'content_image_1' => $this->when((bool)$this->contentImage1, ImageResource::make($this->contentImage1)),
            'content_image_2' => $this->when((bool)$this->contentImage2, ImageResource::make($this->contentImage2)),
        ];
    }
}
