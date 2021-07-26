<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tour extends Model
{
    use SoftDeletes;
    protected $fillable = ['tour_name', 'tour_address', 'regency_id', 'province_id', 'user_id'];
}
