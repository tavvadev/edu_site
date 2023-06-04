<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderproducts extends Model
{
    use HasFactory;
    public $table = 'order_products';
    protected $fillable =  ['id','invoice_id','product_id','quantity','price','requested_qty', 'bill_qty'];
    public $timestamps = false;
}
