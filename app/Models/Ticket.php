<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = ['ticket_name', 'ticket_price', 'detail', 'tour_id', 'user_id'];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order_ticket()
    {
        return $this->hasMany(OrderTicket::class, 'ticket_id');
    }
}
