<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    public $table = 'supplier_details';
    protected $fillable =  ['supplier_details_id','supplier_id','firm_name','bank_account_number','bank_account_name','bank_ifsc','firm_pan_number','gst_number','aadhaar_number', 'supplier_detail_status'];
    public $timestamps = false;
}
