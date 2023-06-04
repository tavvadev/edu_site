<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Orders extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */

     protected $fillable = [
        'invoice_num', 'school_id', 'created_by', 'updated_by'
    ];
    public $timestamps = false;




}