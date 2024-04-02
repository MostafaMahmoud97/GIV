<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wrapping extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "title_ar",
        "title_en",
        "code",
        "color",
        "material",
        "price_egy",
        "price_usd",
        "is_active"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media(){
        return $this->morphMany(Media::class,"mediable");
    }
}
