<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInvoices extends Model
{
    use HasFactory;
    public $table = 'order_invoices';
    protected $fillable =  ['id','order_id','invoice_no','invoice_file_path','invoice_date','total_invoice_qty','invoice_created_at'];
    public $timestamps = false;
}
