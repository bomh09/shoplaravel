<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $fillable = ['customer_id', 'shipping_id', 'payment_id', 'order_total', 'order_status', 'order_date'];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';

    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'customer_id');
    }

    public function shipping(){
        return $this->belongsTo('App\Models\Shipping', 'shipping_id', 'shipping_id');
    }

    public function payment(){
        return $this->belongsTo('App\Models\Payment', 'payment_id', 'payment_id');
    }

    public function order_details(){
        return $this->hasMany('App\Models\OrderDetails', 'order_id');
    }
}
