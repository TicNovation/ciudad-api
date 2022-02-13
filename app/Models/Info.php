<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = 'info';

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
