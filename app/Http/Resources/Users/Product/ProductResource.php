<?php

namespace App\Http\Resources\Users\Product;

use App\Http\Resources\Users\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property int id
 * @property int parent_id
 * @property string title
 * @property string subtitle
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property string meta_slug
 * @property string meta_image
 * @property bool mobile_visibility
 * @property int order
 * @property string id_1c
 * @property int barcode
 * @property string vendor_code
 * @property int count
 * @property string name
 * @property string unit
 * @property string category,
 * @property string volume
 * @property string weight
 * @property string characteristic
 * @property string full_description
 * @property string composition
 * @property string country,
 * @property string status,
 * @property string dimension,
 **/
class ProductResource extends JsonResource
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
            'id_1c' => $this->id_1c,
            'barcode' => $this->barcode,
            'vendor_code' => $this->vendor_code,
            'count' => $this->count,
            'name' => $this->name,
            'unit' => $this->unit,
            'category' => $this->category,
            'volume' => $this->volume,
            'weight' => $this->weight,
            'dimension' => $this->dimension,
            'status' => $this->status,
            'characteristic' => $this->characteristic,
            'full_description' => $this->full_description,
            'composition' => $this->composition,
            'country' => $this->country,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'meta_slug' => $this->meta_slug,
            'meta_image' => $this->meta_image,
            'logo' => ImageResource::collection($this->whenLoaded('logo')),
            'video' => ImageResource::make($this->whenLoaded('video')),
        ];
    }
}
