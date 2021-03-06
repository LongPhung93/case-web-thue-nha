<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table = 'bills';

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function house()
    {
        return $this->belongsTo('App\Models\House','house_id','id');
    }
}
