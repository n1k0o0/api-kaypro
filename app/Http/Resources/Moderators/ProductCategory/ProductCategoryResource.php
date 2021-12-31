<?php

namespace App\Http\Resources\Moderators\ProductCategory;

use App\Http\Resources\Moderators\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use JsonSerializable;

/**
 * @property int id
 * @property int products_count
 * @property int subcategories_count
 * @property string title
 * @property string subtitle
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property string meta_slug
 * @property string meta_image
 * @property bool mobile_visibility
 * @property int order
 * @property Carbon|null updated_at
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
            'banner_menu' => ImageResource::make($this->whenLoaded('bannerMenu')),
            'banner_mobile' => ImageResource::make($this->whenLoaded('bannerMobile')),
            'slider' => ImageResource::collection($this->whenLoaded('slider')),
            'parent' => self::make($this->whenLoaded('parent')),
            'products_count' => $this->products_count,
            'subcategories_count' => $this->subcategories_count,
            'mobile_visibility' => (int)$this->mobile_visibility,
            'updated_at' => $this->updated_at,
        ];
    }
}
