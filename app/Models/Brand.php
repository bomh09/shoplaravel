<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $fillable = ['brand_product_name', 'brand_product_desc', 'brand_product_status'];
    protected $primaryKey = 'brand_product_id';
    protected $table = 'tbl_brand_product';

    public function products(){
        return $this->hasMany('App\Models\Product', 'brand_id');
    }
}
