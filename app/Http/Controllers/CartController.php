<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){
        $productId = $request->product_id_hidden;
        $quantity = $request->qty;

        $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();

        $data['id'] = $request->product_id_hidden;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '1';
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        return Redirect::to('show-cart');
    }

    public function show_cart(){
        $cat_product = DB::table('tbl_cat_product')->where('cat_product_status', '1')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_product_status', '1')->get();
        return view('pages.cart.show_cart')->with(compact('cat_product', 'brand_product'));
    }

    public function del_cart($rowId){   
        Cart::update($rowId, 0);
        return redirect::to('show-cart');
    }

    public function cart_quantity_up($rowId){
        $content = Cart::content();
        foreach($content as $key=>$row){
            Cart::update($rowId, $row->qty + 1);
        }
        return redirect::to('show-cart');
    }

    public function cart_quantity_down($rowId){
        $content = Cart::content();
        foreach($content as $key=>$row){
            Cart::update($rowId, $row->qty - 1);
        }
        return redirect::to('show-cart');
    }
}
