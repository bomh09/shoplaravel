<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $fillable = [
        'product_name', 'cat_id', 'brand_id', 'product_desc', 'product_price', 'product_image', 'product_status'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';

    public function category(){
        return $this->belongsTo('App\Models\Category', 'cat_id', 'cat_product_id');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand', 'brand_id', 'brand_product_id');
    }

    public function order_details(){
        return $this->belongsTo('App\Models\OrderDetails', 'product_id');
    }
}
