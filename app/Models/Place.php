<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'place';

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function scopeWord($query, $word){
        return $query->where('name', 'like', '%'.$word.'%')->orWhere('description', 'like', '%'.$word.'%');
    }
}
