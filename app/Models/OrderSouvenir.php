<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderSouvenir extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'souvenir_id',
        'trx_id',
        'name',
        'phone',
        'email',
        'souvenir_price',
        'payment_id',
        'mark_up_fee',
        'payment_fee',
        'discount_item',
        'discount_payment',
        'total',
        'payment_ref',
        'merchant_ref',
        'status',
    ];

    public const STATUS_WAITING = 0;
    public const STATUS_PROCESS = 1;
    public const STATUS_SUCCESS = 2;
    public const STATUS_EXPIRED = 3;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function souvenir()
    {
        return $this->belongsTo(Souvenir::class, 'souvenir_id');
    }

    public function payment_channel()
    {
        return $this->belongsTo(PaymentChannels::class, 'payment_id');
    }
}
