@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới</h2>
    <?php   ?>
    @foreach ($product->take(6) as $key=>$pro)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <a href="{{URL::to('/product-details/'.$pro->product_id)}}">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{URL::to('public/upload/product/'.$pro->product_image)}}" width="250px" height="250px" alt="" />
                            <h2>{{$pro->product_name}}</h2>
                            <p>{{number_format($pro->product_price).' VNĐ'}}</p>
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

<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">sản phẩm đề xuất</h2>
    
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">	
                @foreach ($product->take(4) as $key=>$pro)
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <a href="{{URL::to('/product-details/'.$pro->product_id)}}">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{URL::to('/public/upload/product/'.$pro->product_image)}}" alt="" />
                                        <h2>{{$pro->product_name}}</h2>
                                        <p>{{number_format($pro->product_price).' VNĐ'}}</p>
                                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="item">	
                @foreach ($product->take(4) as $key=>$pro)
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <a href="{{URL::to('/product-details/'.$pro->product_id)}}">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{URL::to('/public/upload/product/'.$pro->product_image)}}" alt="" />
                                        <h2>{{$pro->product_name}}</h2>
                                        <p>{{number_format($pro->product_price).' VNĐ'}}</p>
                                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
            </a>			
    </div>
</div><!--/recommended_items-->
@endsection