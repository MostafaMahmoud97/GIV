<?php

namespace App\Http\Resources\Admin\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $media = "";
        if ($this->media){
            $media = $this->media->file_path;
        }

        return [
            "id" => $this->id,
            "code" => $this->code,
            "title" => $this->title,
            "media" => $media
        ];
    }
}
