<?php

namespace App\Http\Resources\Moderators\Training;

use App\Http\Resources\Moderators\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property int id
 * @property string name
 * @property string description
 * @property string city
 * @property string date
 * @property string location
 * @property string lecturer
 * @property string price
 * @property string duration
 * @property string lecturer_position
 * @property string lecturer_description
 * @property string meta_title
 * @property string meta_description
 * @property string meta_keywords
 * @property string meta_image
 * @property string meta_slug
 * @property object days
 * @property int seats
 * @property int empty_seats
 * @property bool is_visible
 * @property bool is_online
 * @property object status
 **/
class TrainingResource extends JsonResource
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
            'description' => $this->description,
            'city' => $this->city,
            'location' => $this->location,
            'date' => $this->date,
            'duration' => $this->duration,
            'price' => $this->price,
            'lecturer' => $this->lecturer,
            'lecturer_position' => $this->lecturer_position,
            'lecturer_description' => $this->lecturer_description,
            'seats' => $this->seats,
            'days' => $this->days,
            'empty_seats' => $this->empty_seats,
            'status' => $this->status,
            'is_visible' => (int)$this->is_visible,
            'is_online' => (int)$this->is_online,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'meta_image' => $this->meta_image,
            'meta_slug' => $this->meta_slug,
            'lecturer_avatar' => ImageResource::make($this->whenLoaded('lecturerAvatar')),
            'logo' => ImageResource::make($this->whenLoaded('logo')),
            'banner' => ImageResource::make($this->whenLoaded('banner')),
        ];
    }
}
