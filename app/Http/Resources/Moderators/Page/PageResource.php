<?php

namespace App\Http\Resources\Moderators\Page;

use App\Http\Resources\Moderators\ImageResource;
use App\Http\Resources\Moderators\Slider\SliderResource;
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
 * @property object lineMedia
 * @property object lineImage
 * @property object instagram
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
            'id' => $this->id,
            'name' => $this->name,
            'meta_h1' => $this->meta_h1,
            'meta_title' => $this->meta_title,
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            'content' => $this->content,
            'banner' => $this->when((bool)$this->banner, ImageResource::make($this->banner)),
            'content_image1' => $this->when((bool)$this->contentImage1, ImageResource::make($this->contentImage1)),
            'content_image2' => $this->when((bool)$this->contentImage2, ImageResource::make($this->contentImage2)),
            'line_image' => $this->when((bool)$this->lineImage, ImageResource::make($this->lineImage)),
            'line_media' => $this->when((bool)$this->lineMedia, ImageResource::make($this->lineMedia)),
            'slider' => SliderResource::collection($this->whenLoaded('sliders')),
            'instagram' => ImageResource::collection($this->whenLoaded('instagram')),
        ];
    }
}
