<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Souvenir extends Model
{
    use SoftDeletes;
    protected $fillable = ['souvenir_name', 'souvenir_price', 'store_id'];
}
