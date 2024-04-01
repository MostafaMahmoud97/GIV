<?php

namespace App\Http\Resources\Admin\BusinessRequest;

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
            "store_name" => $this->store_name,
            "phone_number" => $this->phone_number,
            "email" => $this->email,
        ];
    }
}
