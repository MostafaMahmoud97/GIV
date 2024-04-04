<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory,NodeTrait;
    protected $fillable = [
        "id",
        "parent_id",
        "_lft",
        "_rgt",
        "code",
        "title_ar",
        "title_en"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];



    public function media(){
        return $this->morphOne(Media::class,"mediable");
    }
}
