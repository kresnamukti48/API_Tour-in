<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['store_name', 'store_address', 'regency_id', 'province_id', 'user_id', 'tour_id'];
}
