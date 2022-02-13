<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyMenu extends Model
{
    protected $table = 'company_menu';

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
