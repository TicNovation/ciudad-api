<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job';

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function scopeWord($query, $word){
        return $query->where('name', 'like', '%'.$word.'%')->orWhere('description', 'like', '%'.$word.'%')->orWhere('company', 'like', '%'.$word.'%');
    }

}
