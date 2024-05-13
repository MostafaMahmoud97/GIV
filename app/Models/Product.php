<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "title_en",
        "title_ar",
        "code",
        "description_ar",
        "description_en",
        "main_price_egy",
        "main_price_usd",
        "main_instead_of_egy",
        "main_instead_of_usd",
        "is_active"
    ];

    protected $hidden = [
        "create_at",
        "updated_at"
    ];

    public function media(){
        return $this->morphMany(Media::class,"mediable");
    }

    public function Categories(){
        return $this->belongsToMany(Category::class,"product_categories","category_id","product_id","id","id");
    }

    public function Attributes(){
        return $this->belongsToMany(Attribute::class,"product_attributes","product_id","attribute_id","id","id");
    }

    public function Inventory(){
        return $this->hasMany(Inventroy::class,"product_id","id");
    }
}
