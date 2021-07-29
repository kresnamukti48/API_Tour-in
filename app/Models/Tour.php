<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use SoftDeletes;
    protected $fillable = ['tour_name', 'tour_address', 'regency_id', 'province_id', 'user_id'];

    public function virtual_tour()
    {
        return $this->hasMany(Virtualtour::class, 'tour_id');
    }

    public function store()
    {
        return $this->hasMany(Store::class, 'tour_id');
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'tour_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }
}
