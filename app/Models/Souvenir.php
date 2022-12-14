<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Souvenir extends Model
{
    use SoftDeletes;
    protected $fillable = ['souvenir_name', 'souvenir_price', 'store_id', 'user_id'];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function souvenir_stock()
    {
        return $this->hasMany(SouvenirStock::class, 'souvenir_id');
    }

    public function souvenir_stock_ready()
    {
        $stock = $this->souvenir_stock();
        $stock_in = $stock->sum('qty_in');
        $stock_out = $stock->sum('qty_out');
        $stock_ready = $stock_in - $stock_out;

        return $stock_ready;
    }
}
