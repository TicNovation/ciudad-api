<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';

    protected $hidden = [
        'created_at', 'updated_at', 'password'
    ];


}
