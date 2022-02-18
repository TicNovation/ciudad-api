<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'user';

    protected $fillable = [
        'id_firebase', 'city', 'os', 'active', 'id_unique'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

}
