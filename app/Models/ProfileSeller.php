<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileSeller extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'manager_id', 'status'];

    public const STATUS_PENDING = 0;
    public const STATUS_SUCCESS = 1;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
