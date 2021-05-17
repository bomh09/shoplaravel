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

class CategoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = session::get('admin_id');
        if($admin_id){
            return redirect::to('dashboard');
        }else{
            return redirect::to('admin')->send();
        }
    }

    public function add_cat_product(){
        $this->AuthLogin();
        return view('admin.category.add_cat_product');
    }

    public function save_cat_product(Request $request){
        $this->AuthLogin();

        $data = $request->all();
        $cate = new Category();
        $cate->cat_product_name = $data['cat_product_name'];
        $cate->cat_product_desc = $data['cat_product_desc'];
        $cate->cat_product_status = $data['cat_product_status'];
        $cate->save();
        
        session::put('message', 'Thêm danh mục sản phẩm thành công!');
        return redirect::to('add-cat-product');
    }

    public function all_cat_product(){
        $this->AuthLogin();
        
        $all_cat_product = Category::orderBy('cat_product_id', 'DESC')->get();

        $manager_cat_product = view('admin.category.all_cat_product')->with('all_cat_product', $all_cat_product);
        return view('admin_layout')->with('admin.category.all_cat_product', $manager_cat_product);
    }

    public function hidden_cat_product($cat_product_id){
        $this->AuthLogin();
        Category::find($cat_product_id)->update(['cat_product_status'=>0]);

        session::put('message', 'Ẩn danh mục sản phẩm thành công!');
        return redirect::to('all-cat-product');
    }

    public function show_cat_product($cat_product_id){
        $this->AuthLogin();
        Category::find($cat_product_id)->update(['cat_product_status'=>1]);

        session::put('message', 'Hiển thị danh mục sản phẩm thành công!');
        return redirect::to('all-cat-product');
    }

    public function edit_cat_product($cat_product_id){
        $this->AuthLogin();
        $edit_cat_product = Category::find($cat_product_id);
        $manager_cat_product = view('admin.category.edit_cat_product')->with('edit_cat_product', $edit_cat_product);

        return view('admin_layout')->with('admin.category.edit_cat_product', $manager_cat_product);
    }

    public function update_cat_product(Request $request, $cat_product_id){
        $this->AuthLogin();
        
        $data = $request->all();
        $cate = Category::find($cat_product_id);
        $cate->cat_product_name = $data['cat_product_name'];
        $cate->cat_product_desc = $data['cat_product_desc'];
        $cate->cat_product_status = $data['cat_product_status'];
        $cate->save();

        session::put('message', 'Cập nhật mục sản phẩm thành công!');
        return redirect::to('all-cat-product');
    }

    public function del_cat_product($cat_product_id){
        $this->AuthLogin();
        Category::find($cat_product_id)->delete();

        session::put('message', 'Xóa mục sản phẩm thành công!');
        return redirect::to('all-cat-product');
    }

    //show product by category
    public function show_product_by_cat($cat_product_id){
        $cat_product = DB::table('tbl_cat_product')->where('cat_product_status', '1')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_product_status', '1')->get();
        $product = DB::table('tbl_product')->where('product_status', '1')->limit(4)->get();
        $cat_name = DB::table('tbl_cat_product')->where('tbl_cat_product.cat_product_id', $cat_product_id)->limit(1)->get();

        $product_by_cat = DB::table('tbl_product')->join('tbl_cat_product', 'tbl_product.cat_id', '=', 'tbl_cat_product.cat_product_id')
        ->where('tbl_product.cat_id', $cat_product_id)->get();
        
        return view('pages.category.product_by_cat')
        ->with(compact('cat_product', 'product', 'brand_product', 'product_by_cat', 'cat_name'));

    }
}
