<?php

namespace App\Http\Resources\Moderators\User;

use Carbon\Traits\Date;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property int id
 * @property string first_name
 * @property string last_name
 * @property string patronymic
 * @property string email
 * @property string phone
 * @property string address
 * @property string status
 * @property bool entity
 * @property string entity_name
 * @property string entity_address
 * @property string entity_status
 * @property int itn
 * @property int psrn
 * @property string price_type
 * @property bool subscribe
 * @property Date|null updated_at
 */
class UserResource extends JsonResource
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
            'subscribe' => $this->subscribe,
            'updated_at' => $this->updated_at,
        ];
    }
}
