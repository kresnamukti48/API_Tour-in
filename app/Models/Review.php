<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'type', 'data_id', 'review', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
