<?php

namespace App\Http\Resources\Moderators\User;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResource extends JsonResource
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
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'patronymic' => $this->patronymic,
                'status' => $this->status,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'entity' => (int)$this->entity,
                'entity_name' => $this->entity_name,
                'entity_status' => $this->entity_status,
                'itn' => $this->itn,
                'psrn' => $this->psrn,
                'entity_address' => $this->entity_address,
                'updated_at' => $this->updated_at,
        ];
    }
}
