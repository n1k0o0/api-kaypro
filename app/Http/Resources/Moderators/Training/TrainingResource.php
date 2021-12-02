<?php

namespace App\Http\Resources\Moderators\Training;

use App\Http\Resources\Moderators\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TrainingResource extends JsonResource
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
                'lecturer_avatar' => ImageResource::make($this->whenLoaded('lecturerAvatar')),
                'logo' => ImageResource::make($this->whenLoaded('logo')),
        ];
    }
}
