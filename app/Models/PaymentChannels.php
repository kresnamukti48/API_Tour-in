<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;

class PaymentChannels extends Model
{
    use HasFactory, SoftDeletes, Eloquence;

    protected $guarded = ['id'];

    protected $searchableColumns = ['payment_name'];

    public const STATUS_DISABLED = 0;
    public const STATUS_ACTIVE = 1;

    public function method()
    {
        return $this->belongsTo(PaymentVendorMethod::class, 'payment_method_vendor_id');
    }
}
