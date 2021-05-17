<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Brand;
use App\Models\Category;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect::to('dashboard');
        }else{
            return redirect::to('admin')->send();
        }
    }

    public function add_brand_product(){
        $this->AuthLogin();
        return view('admin.brand.add_brand_product');
    }
    
    public function save_brand_product(Request $request){
        $this->AuthLogin();

        $data = $request->all();
        $brand = new Brand();
        $brand->brand_product_name = $data['brand_product_name'];
        $brand->brand_product_desc = $data['brand_product_desc'];
        $brand->brand_product_status = $data['brand_product_status'];
        $brand->save();

        session::put('message', 'Thêm thương hiệu sản phẩm thành công!');
        return redirect::to('add-brand-product');
    }

    public function all_brand_product(){
        $this->AuthLogin();
        $all_brand_product = Brand::orderBy('brand_product_id', 'DESC')->get();
        $manager_brand_product = view('admin.brand.all_brand_product')->with('all_brand_product', $all_brand_product);
        return view('admin_layout')->with('all_brand_product', $manager_brand_product);
    }

    public function show_brand_product($brand_product_id){
        $this->AuthLogin();

        Brand::find($brand_product_id)->update(['brand_product_status'=>1]);

        session::put('message', 'Hiển thị thương hiệu sản phẩm thành công!');
        return redirect::to('all-brand-product');
    }

    public function hidden_brand_product($brand_product_id){
        $this->AuthLogin();

        Brand::find($brand_product_id)->update(['brand_product_status'=>0]);

        session::put('message', 'Ẩn thị thương hiệu sản phẩm thành công!');
        return redirect::to('all-brand-product');
        
    }

    public function edit_brand_product($brand_product_id){
        $this->AuthLogin();
        
        $edit_brand_product = Brand::find($brand_product_id);

        $manager_brand_product = view('admin.brand.edit_brand_product')->with('edit_brand_product', $edit_brand_product);
        return view('admin_layout')->with('admin.brand.edit_brand_product',$manager_brand_product);
    }

    public function update_brand_product(Request $request, $brand_product_id){
        $this->AuthLogin();

        $data = $request->all();
        $brand = Brand::find($brand_product_id);
        $brand->brand_product_name = $data['brand_product_name'];
        $brand->brand_product_desc = $data['brand_product_desc'];
        $brand->brand_product_status = $data['brand_product_status'];
        $brand->save();

        session::put('message', 'Cập nhật thương hiệu sản phẩm thành công!');
        return redirect::to('all-brand-product');
    }

    public function del_brand_product($brand_product_id){
        $this->AuthLogin();
        Brand::find($brand_product_id)->delete();
        session::put('message', 'Xóa thương hiệu sản phẩm thành công!');
        return redirect::to('all-brand-product');
    }
    
    //show product by brand
    public function show_product_by_brand($brand_product_id){
        $cat_product = DB::table('tbl_cat_product')->where('cat_product_status', '1')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_product_status', '1')->get();
        $product = DB::table('tbl_product')->where('product_status', '1')->limit(4)->get();
        $brand_name = DB::table('tbl_brand_product')->where('tbl_brand_product.brand_product_id', $brand_product_id)->limit(1)->get();

        $product_by_brand = DB::table('tbl_product')->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_product_id')
        ->where('tbl_product.brand_id', $brand_product_id)->get();

        return view('pages.brand.product_by_brand')
        ->with(compact('cat_product', 'brand_product', 'product', 'product_by_brand', 'brand_name'));

    }
}
