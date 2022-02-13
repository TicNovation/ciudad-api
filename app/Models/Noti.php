<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noti extends Model
{
    protected $table = 'noti';

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function scopeWord($query, $word){
        return $query->where('title', 'like', '%'.$word.'%')->orWhere('description', 'like', '%'.$word.'%');
    }
}
