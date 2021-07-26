<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Virtualtour extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'tour_id'];
}
