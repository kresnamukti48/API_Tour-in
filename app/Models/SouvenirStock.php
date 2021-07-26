<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SouvenirStock extends Model
{
    use SoftDeletes;
    protected $fillable = ['date', 'qty_in', 'qty_out', 'note', 'souvenir_id'];
}
