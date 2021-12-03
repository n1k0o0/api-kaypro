<?php

namespace App\Http\Resources\Users\Training;

use App\Http\Resources\Users\ImageResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property int id
 * @property string city
 * @property string location
 * @property string description
 * @property string name
 * @property string date
 * @property string price
 * @property int seats
 * @property string duration
 * @property int empty_seats
 * @property string status
 * @property string lecturer
 * @property string lecturer_description
 * @property string lecturer_position
 * @property array days
 * @method getUrl
 **/
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
                'location' => $this->location,
                'city' => $this->city,
                'date' => $this->date,
                'duration' => $this->duration,
                'price' => $this->price,
                'seats' => $this->seats,
                'empty_seats' => $this->empty_seats,
                'status' => $this->status,
                'lecturer' => $this->lecturer,
                'lecturer_description' => $this->lecturer_description,
                'lecturer_position' => $this->lecturer_position,
                'days' => $this->days,
                'lecturer_avatar' => ImageResource::make($this->whenLoaded('lecturerAvatar')),
                'logo' => ImageResource::make($this->whenLoaded('logo'))
        ];
    }
}
