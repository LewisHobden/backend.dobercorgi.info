<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    //
    protected $fillable = [
        "title","icon","description"
    ];

    public function resources()
    {
        return $this->hasMany(Resource::class,"category_id");
    }
}
