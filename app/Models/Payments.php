<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'order_id', 'supplier_id', 'bill_amount', 'created_at','tds_amount','total_amount','paid_status','paid_date','transaction_id'
    ];
}
