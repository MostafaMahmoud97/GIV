<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventroy extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "value_one_id",
        "value_two_id",
        "value_three_id",
        "product_id",
        "media_id",
        "value_title",
        "base_price_egy",
        "price_instead_of_egy",
        "base_price_usd",
        "price_instead_of_usd",
        "available",
        "sold",
        "holding"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media(){
        return $this->belongsTo(Media::class,"media_id","id");
    }

    public function Product(){
        return $this->belongsTo(Product::class,"product_id","id");
    }
}
