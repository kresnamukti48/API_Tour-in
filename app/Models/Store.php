<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class store extends Model
{
    use SoftDeletes;
    protected $fillable = ['store_name', 'store_address', 'regency_id', 'province_id', 'user_id', 'tour_id'];
}
