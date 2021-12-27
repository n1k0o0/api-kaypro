<?php

namespace App\Http\Resources\Moderators\Slider;

use App\Http\Resources\Moderators\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property int id
 * @property string title
 * @property string subtitle
 * @property string link
 * @property string button_text
 * @property int order
 */
class SliderResource extends JsonResource
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
            'link' => $this->link,
            'button_text' => $this->button_text,
            'order' => $this->order,
            'image' => ImageResource::make($this->whenLoaded('image'))
        ];
    }
}
