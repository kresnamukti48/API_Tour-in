<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Virtualtour extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'tour_id'];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function virtual_tour_gallery()
    {
        return $this->hasMany(Virtualtourgallery::class, 'virtualtour_id');
    }
}
