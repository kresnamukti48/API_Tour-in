<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;

class PaymentCategory extends Model
{
    use HasFactory, SoftDeletes, Eloquence;

    protected $guarded = ['id'];

    protected $searchableColumns = ['name'];

    public const CATEGORY_VA = 1;
    public const CATEGORY_CC = 2;
    public const CATEGORY_STORE = 3;
    public const CATEGORY_EWALLET = 4;
}
