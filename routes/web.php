<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Front-End
Route::get('/', 'HomeController@index');
Route::get('/trang-chu', 'HomeController@index');
Route::post('/search', 'HomeController@search');

Route::get('cat-product/{cat_product_id}', 'CategoryProduct@show_product_by_cat');
Route::get('/brand-product/{brand_product_id}', 'BrandProduct@show_product_by_brand');
Route::get('/product-details/{product_id}', 'ProductController@product_details');

// Back-End
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard', 'AdminController@show_dashboard');
Route::post('/admin-dashboard', 'AdminController@dashboard');
Route::get('/logout', 'AdminController@logout');

// Category Product
Route::get('/add-cat-product', 'CategoryProduct@add_cat_product');
Route::get('/all-cat-product', 'CategoryProduct@all_cat_product');
Route::get('/edit-cat-product/{cat_product_id}', 'CategoryProduct@edit_cat_product');
Route::get('/del-cat-product/{cat_product_id}', 'CategoryProduct@del_cat_product');


Route::get('/hidden-cat-product/{cat_product_id}', 'CategoryProduct@hidden_cat_product');
Route::get('/show-cat-product/{cat_product_id}', 'CategoryProduct@show_cat_product');

Route::post('/save-cat-product', 'CategoryProduct@save_cat_product');
Route::post('/update-cat-product/{cat_product_id}', 'CategoryProduct@update_cat_product');

// Brand Product
Route::get('/add-brand-product', 'BrandProduct@add_brand_product');
Route::get('/all-brand-product', 'BrandProduct@all_brand_product');
Route::get('/edit-brand-product/{brand_product_id}', 'BrandProduct@edit_brand_product');
Route::get('/del-brand-product/{brand_product_id}', 'BrandProduct@del_brand_product');

Route::get('/show-brand-product/{brand_product_id}', 'BrandProduct@show_brand_product');
Route::get('/hidden-brand-product/{brand_product_id}', 'BrandProduct@hidden_brand_product');


Route::post('/save-brand-product', 'BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}', 'BrandProduct@update_brand_product');

//Product
Route::get('/add-product', 'ProductController@add_product');
Route::get('/all-product', 'ProductController@all_product');
Route::get('/edit-product/{product_id}', 'ProductController@edit_product');
Route::get('/del-product/{product_id}', 'ProductController@del_product');

Route::get('/show-product/{product_id}', 'ProductController@show_product');
Route::get('/hidden-product/{product_id}', 'ProductController@hidden_product');


Route::post('/save-product', 'ProductController@save_product');
Route::post('/update-product/{product_id}', 'ProductController@update_product');

//cart
Route::post('/save-cart', 'CartController@save_cart');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/del-cart/{rowId}', 'CartController@del_cart');
Route::get('/cart-quantity-up/{rowId}', 'CartController@cart_quantity_up');
Route::get('/cart-quantity-down/{rowId}', 'CartController@cart_quantity_down');

//checkout
Route::get('/login-checkout', 'CheckoutController@login_checkout');
Route::get('/logout-checkout', 'CheckoutController@logout_checkout');

Route::post('/add-customer', 'CheckoutController@add_customer');
Route::post('/login-customer', 'CheckoutController@login_customer');
Route::post('/save-checkout-customer', 'CheckoutController@save_checkout_customer');
Route::post('/login-customer', 'CheckoutController@login_customer');
Route::get('/show-checkout', 'CheckoutController@show_checkout'); 

Route::get('/payment', 'CheckoutController@payment');
Route::post('/order-place', 'CheckoutController@order_place');

//order
Route::get('/manage-order', 'OrderController@manage_order');
Route::get('/view-order/{order_id}', 'OrderController@view_order');
Route::get('/del-order/{order_id}', 'OrderController@del_order');