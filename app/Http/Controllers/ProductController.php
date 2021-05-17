<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect::to('dashboard');
        }else{
            return redirect::to('admin')->send();
        }
    }

    public function add_product(){
        $this->AuthLogin();

        $cat_product = Category::with('products')->get();
        $brand_product = Brand::with('products')->get();
        // $add_product =  Product::with('brand', 'category')->get();

        return view('admin.product.add_product')->with(compact('cat_product', 'brand_product'));
    }

    public function save_product(Request $request){
        $this->AuthLogin();

        $data = $request->all();
        $product = new Product();
        $product->product_name = $data['product_name'];
        $product->cat_id = $data['cat_id'];
        $product->brand_id = $data['brand_id'];
        $product->product_price = $data['product_price'];
        $product->product_desc = $data['product_desc'];
        $product->product_status = $data['product_status'];

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0,99).'.'.$get_image->getClientOriginalExtension();

            $get_image -> move('public/upload/product/',$new_image);
            $product->product_image = $data['product_image'] = $new_image;
            $product->save();
            session::put('message', ' Thêm sản phẩm thành công!');
            return redirect::to('add-product');
        }
    
        $product->product_image = $data['product_image']='';
        $product->save();
        session::put('message', ' Thêm sản phẩm thành công!');
        return redirect::to('add-product');
    }

    // liệt kê sản phẩm
    public function all_product(){
        $this->AuthLogin();

        $all_product = Product::with('brand','category')->orderby('product_id', 'desc')->get();

        $manager_product = view('admin.product.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('all_product', $manager_product);
    }

    //ẩn hiện sản phẩm
    public function show_product($product_id){
        $this->AuthLogin();

        Product::find($product_id)->update(['product_status'=>1]);
        session::put('message', 'Hiển thị sản phẩm thành công!');
        return redirect::to('all-product');
    }

    public function hidden_product($product_id){
        $this->AuthLogin();
        Product::find($product_id)->update(['product_status'=>0]);
        session::put('message', 'Ẩn sản phẩm thành công!');
        return redirect::to('all-product');
    }

    // cập nhật
    public function edit_product($product_id){
        $this->AuthLogin();

        // $cat_product = DB::table('tbl_cat_product')->get();
        // $brand_product = DB::table('tbl_brand_product')->get();
        // $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();

        $edit_product = Product::with('brand','category')->find($product_id);
        $cat_product = Category::with('products')->get();
        $brand_product = Brand::with('products')->get();
        
        $manager_product = view('admin.product.edit_product')->with(compact('edit_product', 'cat_product', 'brand_product'));
        return view('admin_layout')->with('admin.product.edit_product', $manager_product);
    }

    public function update_product(Request $request, $product_id){
        $this->AuthLogin();
        // $data = array();
        // $data['product_name'] = $request->product_name;
        // $data['cat_id'] = $request->cat_id;
        // $data['brand_id'] = $request->brand_id;
        // $data['product_price'] = $request->product_price;
        // $data['product_desc'] = $request->product_desc;

        $data = $request->all();
        $product = Product::find($product_id);
        $product->product_name = $data['product_name'];
        $product->cat_id = $data['cat_id'];
        $product->brand_id = $data['brand_id'];
        $product->product_price = $data['product_price'];
        $product->product_desc = $data['product_desc'];

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0,99).'.'.$get_image->getClientOriginalExtension();

            $get_image -> move('public/upload/product/',$new_image);
            $product->product_image = $data['product_image'] = $new_image;
            // DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            $product->save();
            session::put('message', 'Cập nhật sản phẩm thành công!');
            return redirect::to('all-product');
        }

        // DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        $product->save();
        session::put('message', 'Cập nhật sản phẩm thành công!');
        return redirect::to('all-product');
    }

    public function del_product($product_id){
        $this->AuthLogin();
        // DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Product::find($product_id)->delete();
        session::put('message', 'Xóa sản phẩm thành công!');
        return redirect::to('all-product');
    }

    //product details
    public function product_details($product_id){
        $cat_product = DB::table('tbl_cat_product')->where('cat_product_status', '1')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_product_status', '1')->get();

        $details_product = DB::table('tbl_product')->join('tbl_cat_product', 'tbl_cat_product.cat_product_id', '=', 'tbl_product.cat_id')
        ->join('tbl_brand_product', 'tbl_brand_product.brand_product_id', '=', 'tbl_product.brand_id')
        ->where('tbl_product.product_id', $product_id)->where('product_status', '1')->get();

        foreach($details_product as $key=>$value){
            $cat_product_id = $value->cat_product_id;
        }
        $related_product = DB::table('tbl_product')->join('tbl_cat_product', 'tbl_cat_product.cat_product_id', '=', 'tbl_product.cat_id')
        ->join('tbl_brand_product', 'tbl_brand_product.brand_product_id', '=', 'tbl_product.brand_id')
        ->where('tbl_cat_product.cat_product_id', $cat_product_id)->whereNotIn('tbl_product.product_id', [$product_id])->get();

        return view('pages.product.product_details')
        ->with(compact('cat_product', 'brand_product', 'details_product', 'related_product'));
    }

}
