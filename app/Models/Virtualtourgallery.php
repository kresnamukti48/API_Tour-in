<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Virtualtourgallery extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'gallery', 'virtualtour_id'];
}
