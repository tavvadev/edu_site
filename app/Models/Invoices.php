<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    public $table = 'invoices';
    protected $fillable =  ['id','invoice_num','supplier_id','school_id','requester_id','approved_by','total_price','total_qty','invoice_status'];
    public $timestamps = false;
    
}
