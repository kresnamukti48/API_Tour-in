<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = ['tour_name', 'tour_address', 'regency_id', 'province_id', 'user_id'];
}
