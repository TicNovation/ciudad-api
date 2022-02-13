<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function addresses(){
        return $this->hasMany(CompanyAddress::class, 'id_company');
    }

    public function menu(){
        return $this->hasMany(CompanyMenu::class, 'id_company');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class, 'id_subcategory');
    }

    public function schedule(){
        return $this->hasMany(CompanySchedule::class, 'id_company');
    }

    public function scopeWord($query, $word){
        return $query->where('name', 'like', '%'.$word.'%')->orWhere('description', 'like', '%'.$word.'%');
    }

    public function open(){
        $day = date("l");
        $now = date("H:i:s");
        return $this->hasOne(CompanySchedule::class, 'id_company')->select('day','time_open', 'time_close', 'open', 'id_company')->where('day', $day)->where('open', 1)->where('time_open', '<', $now)->where('time_close', '>', $now);
    }

}
