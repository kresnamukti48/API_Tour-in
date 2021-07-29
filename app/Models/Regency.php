<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'master_indonesia_cities';

    public function tour()
    {
        return $this->hasMany(Tour::class, 'regency_id');
    }

    public function store()
    {
        return $this->hasMany(Store::class, 'regency_id');
    }
}
