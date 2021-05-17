@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới</h2>
    <?php   ?>
    @foreach ($search_product as $key=>$search)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <a href="{{URL::to('/product-details/'.$search->product_id)}}">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{URL::to('public/upload/product/'.$search->product_image)}}" width="250px" height="250px" alt="" />
                            <h2>{{$search->product_name}}</h2>
                            <p>{{number_format($search->product_price).' VNĐ'}}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                        </div>
                    </div>
                </a>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>	
     @endforeach
</div><!--features_items-->
@endsection