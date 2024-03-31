<?php

namespace App\Http\Resources\Admin\GiftBox;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "box_name" => $this->name,
            "box_code" => $this->box_code,
            "price" => $this->price,
            "is_active" => $this->is_active
        ];
    }
}
