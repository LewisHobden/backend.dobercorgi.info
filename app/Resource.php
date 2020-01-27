<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    //
    protected $fillable = [
        "category_id","title","action","file_key","content"
    ];
}
