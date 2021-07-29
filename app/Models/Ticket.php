<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = ['ticket_qty', 'ticket_price', 'checkin', 'tour_id'];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}
