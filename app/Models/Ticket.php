<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['ticket_qty', 'ticket_price', 'checkin', 'tour_id'];
}
