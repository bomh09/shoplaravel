<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){
        $cat_product = DB::table('tbl_cat_product')->where('cat_product_status', '1')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_product_status', '1')->get();
        $product = DB::table('tbl_product')->where('product_status', '1')->get();
        return view('pages.home')
        ->with(compact('cat_product', 'brand_product', 'product'));
    }

    public function search(Request $request){
        $keywords = $request->keywords_search;
        $cat_product = DB::table('tbl_cat_product')->where('cat_product_status', '1')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_product_status', '1')->get();
        $search_product = DB::table('tbl_product')->join('tbl_cat_product', 'tbl_cat_product.cat_product_id', '=', 'tbl_product.cat_id')
        ->join('tbl_brand_product', 'tbl_brand_product.brand_product_id', '=', 'tbl_product.brand_id')
        ->where('cat_product_name', 'like', '%' . $keywords . '%')->orWhere('brand_product_name', 'like', '%' . $keywords . '%')
        ->orWhere('product_name', 'like', '%' . $keywords . '%')->get();

        return view('pages.product.search')->with(compact('cat_product', 'brand_product', 'search_product'));
    }
}
