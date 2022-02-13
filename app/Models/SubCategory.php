<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_category';

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
