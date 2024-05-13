<?php

namespace App\Http\Resources\Admin\Inventory;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexInventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $item_media = "";
        if($this->media){
            $item_media = $this->media->file_path;
        }


        return [
            "id" => $this->id,
            "product" => $this->Product,
            "item_title" => $this->value_title,
            "base_price_egy" => $this->base_price_egy,
            "base_price_usd" => $this->base_price_usd,
            "available" => $this->available,
            "sold" => $this->sold,
            "holding" => $this->holding,
            "media" => $item_media
        ];
    }
}
