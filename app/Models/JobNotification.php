<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobNotification extends Model
{
    protected $table = 'job_notification';

    protected $hidden = [
        'created_at', 'updated_at'
    ];

}
