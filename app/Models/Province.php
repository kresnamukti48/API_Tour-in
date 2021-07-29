<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'master_indonesia_provinces';

    public function tour()
    {
        return $this->hasMany(Tour::class, 'province_id');
    }

    public function store()
    {
        return $this->hasMany(Store::class, 'province_id');
    }
}
