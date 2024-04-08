<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "title"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function Values(){
        return $this->hasMany(Value::class,"attribute_id","id");
    }
}
