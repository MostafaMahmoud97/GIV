<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessRequest extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "id",
        "store_name",
        "no_branches",
        "store_type",
        "website",
        "store_address",
        "first_name",
        "last_name",
        "phone_number",
        "email",
        "is_view"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function media(){
        return $this->morphMany(Media::class,"mediable");
    }

    public function national_ids_media(){
        return $this->morphMany(Media::class,"mediable")->where("title","National ID");
    }

    public function commercial_record_media(){
        return $this->morphMany(Media::class,"mediable")->where("title","commercial record");
    }

    public function tax_register_media(){
        return $this->morphMany(Media::class,"mediable")->where("title","tax register");
    }

}
