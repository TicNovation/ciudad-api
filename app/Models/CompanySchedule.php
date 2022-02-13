<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySchedule extends Model
{
    protected $table = 'company_schedule';

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
