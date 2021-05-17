<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
Session_start();

class OrderController extends Controller
{
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect::to('dashboard');
        }else{
            return redirect::to('admin')->send();
        }
    }
    
    //manage order
    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
        ->join('tbl_shipping', 'tbl_shipping.shipping_id', '=', 'tbl_order.shipping_id')
        ->orderby('order_id', 'desc')->get();
        $manager_order = view('admin.order.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('all_order', $manager_order);
    }

    public function view_order($order_id){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
        ->join('tbl_shipping', 'tbl_shipping.shipping_id', '=', 'tbl_order.shipping_id')
        ->join('tbl_order_details', 'tbl_order_details.order_id', '=', 'tbl_order.order_id')
        ->join('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
        ->select('tbl_order.*', 'tbl_customer.*', 'tbl_shipping.*', 'tbl_order_details.*', 'tbl_product.*')
        ->where('tbl_order.order_id', $order_id)
        ->get();
       
        $manager_order_by_id = view('admin.order.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.order.view_order', $manager_order_by_id);
    }
}
