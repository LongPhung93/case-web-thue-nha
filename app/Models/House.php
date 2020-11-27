<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $table = "houses";

    public function image()
    {
        return $this->hasMany('App\Models\Image','house_id','id');
    }

}
