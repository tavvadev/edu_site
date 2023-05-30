<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    use HasFactory;
    public $table = 'schools';
    protected $fillable =  ['id','code','school_name','village_id','district_id','UDISE_code','latitude','hm_name','hm_contact_num','school_category','school_mngmt','school_type','class_one','class_two','class_three','class_four','class_six','class_seven','class_eight','class_nine','class_ten','is_nabard'];
    public $timestamps = false;
}
