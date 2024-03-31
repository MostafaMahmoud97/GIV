<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftBox extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "id",
        "box_name_en",
        "box_name_ar",
        "box_code",
        "price",
        "width",
        "height",
        "length",
        "is_active"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function media(){
        return $this->morphMany(Media::class,"mediable");
    }
}
