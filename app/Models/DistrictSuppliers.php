<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictSuppliers extends Model
{
    use HasFactory;
    public $table = 'orders';
    protected $fillable =  ['id','dist_id','supplier_id'];
    public $timestamps = false;
}
