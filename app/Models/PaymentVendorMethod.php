<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;

class PaymentVendorMethod extends Model
{
    use HasFactory, SoftDeletes, Eloquence;

    protected $guarded = ['id'];

    protected $searchableColumns = ['name', 'code', 'vendor.name', 'category.name'];

    public const STATUS_DISABLED = false;
    public const STATUS_ACTIVE = true;

    public const TYPE_FIXED = 1;
    public const TYPE_PERCENTAGE = 2;

    public const TYPE_FEE_PG_FIXED = 1;
    public const TYPE_FEE_PG_PERCENTAGE = 2;

    public const TYPE_DISC_PG_FIXED = 1;
    public const TYPE_DISC_PG_PERCENTAGE = 2;

    public function vendor()
    {
        return $this->belongsTo(PaymentVendor::class, 'payment_vendor_id');
    }

    public function category()
    {
        return $this->belongsTo(PaymentCategory::class, 'payment_category_id');
    }

    public function channel()
    {
        return $this->hasOne(PaymentChannels::class, 'payment_method_vendor_id');
    }

    public static function getChannelId($code, $vendorId)
    {
        return optional(PaymentVendorMethod::whereCode($code)->wherePaymentVendorId($vendorId)->firstOrFail())->channel->id;
    }

    public function getType()
    {
        $type = null;
        switch ($this->type) {
            case self::TYPE_FIXED:
                $type = 'Fixed Markup';
                break;

            case self::TYPE_PERCENTAGE:
                $type = 'Percentage Markup';
                break;
        }

        return $type;
    }

    public function getMarkupAmount()
    {
        $markupAmount = null;
        switch ($this->type) {
            case self::TYPE_FIXED:
                $markupAmount = $this->markup;
                break;

            case self::TYPE_PERCENTAGE:
                $markupAmount = $this->markup.'%';
                break;
        }

        return $markupAmount;
    }

    public function getFeePaymentAmount()
    {
        $feePaymentAmount = null;
        switch ($this->type_fee) {
            case self::TYPE_FEE_PG_FIXED:
                $feePaymentAmount = $this->fee_pg;
                break;

            case self::TYPE_FEE_PG_PERCENTAGE:
                $feePaymentAmount = $this->fee_pg.'%';
                break;
        }

        return $feePaymentAmount;
    }

    public function getDiscPaymentAmount()
    {
        $discPaymentAmount = null;
        switch ($this->type_disc) {
            case self::TYPE_DISC_PG_FIXED:
                $discPaymentAmount = $this->disc_pg;
                break;

            case self::TYPE_DISC_PG_PERCENTAGE:
                $discPaymentAmount = $this->disc_pg.'%';
                break;
        }

        return $discPaymentAmount;
    }

    public function getMarkupPrice($price)
    {
        $markup_price = null;
        switch ($this->type) {
            case self::TYPE_FIXED:
                $markup_price = $price + $this->markup;
                break;

            case self::TYPE_PERCENTAGE:
                $markup_price = $price + ($price * ($this->markup / 100));
                break;
        }

        return $markup_price;
    }

    public function getFeePaymentPrice($price)
    {
        $fee_payment = null;
        switch ($this->type_fee) {
            case self::TYPE_FEE_PG_FIXED:
                $fee_payment = $this->fee_pg;
                break;

            case self::TYPE_FEE_PG_PERCENTAGE:
                $fee_payment = ($this->fee_pg / 100) * $price;
                break;
        }

        return $fee_payment;
    }

    public function getDiscPaymentPrice($price)
    {
        $disc_payment = null;
        switch ($this->type_disc) {
            case self::TYPE_DISC_PG_FIXED:
                $disc_payment = $this->disc_pg;
                break;

            case self::TYPE_DISC_PG_PERCENTAGE:
                $disc_payment = ($this->disc_pg / 100) * $price;
                break;
        }

        return $disc_payment;
    }
}
