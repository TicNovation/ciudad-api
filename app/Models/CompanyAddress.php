<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyAddress extends Model
{
    protected $table = 'company_address';

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
