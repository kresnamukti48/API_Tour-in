<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;

class PaymentVendor extends Model
{
    use HasFactory, SoftDeletes, Eloquence;

    protected $guarded = ['id'];

    protected $searchableColumns = ['name'];

    public const VENDOR_TRIPAY = 1;
    public const VENDOR_DUITKU = 2;
    public const VENDOR_XENDIT = 3;
    public const VENDOR_MIDTRANS = 4;
    public const VENDOR_VOUCHERGAME_TELKOMSEL = 5;
    public const VENDOR_VOUCHERGAME_XL = 6;

    public function methods()
    {
        return $this->hasMany(PaymentVendorMethod::class, 'payment_vendor_id');
    }
}
