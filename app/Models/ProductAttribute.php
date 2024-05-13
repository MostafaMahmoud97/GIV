<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "product_id",
        "attribute_id"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
