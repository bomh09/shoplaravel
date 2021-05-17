<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Payment;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CheckoutController extends Controller
{
    public function login_checkout(){
        $cat_product = Category::with('products')->get();
        $brand_product = Brand::with('products')->get();
        return view('pages.checkout.login_checkout')->with(compact('cat_product', 'brand_product'));
    }

    public function add_customer(Request $request){
        // $data = array();
        // $data['customer_name'] = $request->customer_name;
        // $data['customer_email'] = $request->customer_email;
        // $data['customer_password'] = md5($request->customer_password);
        // $data['customer_phone'] = $request->customer_phone;

        $data = $request->all();
        $customer = new Customer();
        $customer->customer_name = $data['customer_name'];
        $customer->customer_email = $data['customer_email'];
        $customer->customer_password = md5($data['customer_password']);
        $customer->customer_phone = $data['customer_phone'];
        $customer->save();
        $customer->customer_id;
        $customer_id = Customer::find($customer->customer_id);
        // $customer_id = DB::table('tbl_customer')->insertGetId($data);
        session::put('customer_id', $customer_id);
        session::put('customer_name', $customer->customer_name);
        return redirect::to('/show-checkout');
    }

    public function show_checkout(){
        $cat_product = Category::with('products')->get();
        $brand_product = Brand::with('products')->get();
        return view('pages.checkout.show_checkout')->with(compact('cat_product', 'brand_product'));
    }

    public function logout_checkout(){
        Session::flush();
        return redirect::to('/login-checkout');
    }

    public function login_customer(Request $request){
        $customer_name = $request->customer_name;
        // 
        $customer_email = $request->customer_email;
        $customer_password = md5($request->customer_password);

        $result = Customer::where(['customer_email' => $customer_email, 'customer_password' => $customer_password])->first();

        if($result){
            session::put('customer_email', $result->customer_email);
            session::put('customer_id', $result->customer_id);
            session::put('customer_name', $customer_name);
            return redirect('/show-checkout');
        }else{
            session::put('message', 'Email hoặc mật khẩu không đúng!');
            return redirect('/login-checkout');
        }
    }

    public function save_checkout_customer(Request $request){
        // $data = array();
        // $data['shipping_name'] = $request->shipping_name;
        // $data['shipping_email'] = $request->shipping_email;
        // $data['shipping_address'] = $request->shipping_address;
        // $data['shipping_phone'] = $request->shipping_phone;
        // $data['shipping_note'] = $request->shipping_note;
        // $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_note = $data['shipping_note'];
        $shipping->save();
        $shipping->shipping_id;

        $shipping_id = Shipping::find($shipping->shipping_id);

        session::put('shipping_id', $shipping_id);
        session::put('shipping_name', $shipping->shipping_name);
        return redirect::to('/payment');
    }

    public function payment(){
        $cat_product = DB::table('tbl_cat_product')->where('cat_product_status', '1')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_product_status', '1')->get();
        return view('pages.checkout.payment')->with(compact('cat_product', 'brand_product'));
    }

    public function order_place(Request $request){
        //insert payment
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_date'] = date('Y/m/d H:i:s');
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order details
        $content = Cart::content();
        foreach($content as $key=>$v_content){
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_qty'] = $v_content->qty;
            $order_id = DB::table('tbl_order_details')->insert($order_d_data);
        }

        if($data['payment_method']==1){
            echo 'Thanh toán ATM';
        }else{
            Cart::destroy();
            $cat_product = DB::table('tbl_cat_product')->where('cat_product_status', '1')->get();
            $brand_product = DB::table('tbl_brand_product')->where('brand_product_status', '1')->get();
            return view('pages.checkout.hand_cash')->with(compact('cat_product', 'brand_product'));
        }

    }
}
