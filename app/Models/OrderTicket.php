<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTicket extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'ticket_id',
        'trx_id',
        'name',
        'phone',
        'email',
        'ticket_price',
        'mark_up_fee',
        'payment_fee',
        'discount_item',
        'discount_payment',
        'total',
        'payment_ref',
        'merchant_ref',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
