<?php

namespace App\Http\Resources\Moderators\ProductCategory;

use App\Http\Resources\Moderators\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property int id
 * @property string title
 * @property string subtitle
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property string meta_slug
 * @property string meta_image
 * @property bool mobile_visibility
 * @property int order
 **/
class ProductCategoryResource extends JsonResource
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
            'subtitle' => $this->subtitle,
            'order' => $this->order,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'meta_slug' => $this->meta_slug,
            'meta_image' => $this->meta_image,
            'logo' => ImageResource::make($this->whenLoaded('logo')),
            'banner' => ImageResource::make($this->whenLoaded('banner')),
            'mobile_visibility' => (int)$this->mobile_visibility,
        ];
    }
}
