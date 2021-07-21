<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Souvenir extends Model
{
    protected $fillable = ['souvenir_name', 'souvenir_price', 'store_id'];
}
