<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $fillable = ['cat_product_name', 'cat_product_desc', 'cat_product_status'];
    protected $primaryKey = 'cat_product_id';
    protected $table = 'tbl_cat_product';

    public function products(){
        return $this->hasMany('App\Models\Product', 'cat_id');
    }
}
