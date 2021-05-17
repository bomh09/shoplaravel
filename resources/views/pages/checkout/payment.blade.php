@extends('layout')
@section('content')
    
<section id="cart_items">
    <div class="breadcrumbs">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
            <li class="active">Thanh toán giỏ hàng</li>
        </ol>
    </div><!--/breadcrums-->
    <div class="review-payment">
        <h2>Xem lại giỏ hàng</h2>
    </div>
    <div class="table-responsive cart_info">
        <?php $content = Cart::content(); ?>
        <table class="table table-condensed">
            <thead>
                <tr class="cart_menu">
                    <td class="image">Hình ảnh</td>
                    <td class="description">Mô tả</td>
                    <td class="price">Giá</td>
                    <td class="quantity">Số lượng</td>
                    <td class="total">Tổng</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($content as $key=>$v_content)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('/public/upload/product/'.$v_content->options->image)}}" width="80px" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="{{URL::to('/product-details/'.$v_content->id)}}">{{$v_content->name}}</a></h4>
                            <p>Mã ID: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price).' VNĐ'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href="{{URL::to('/cart-quantity-up/'.$v_content->rowId)}}">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{$v_content->qty}}" autocomplete="off" size="2" disabled>
                                <a class="cart_quantity_down" href="{{URL::to('/cart-quantity-down/'.$v_content->rowId)}}">
                                    <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                    $subtotal = $v_content->price * $v_content->qty;
                                    echo number_format($subtotal)." VNĐ";
                                ?>    
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/del-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="review-payment" style="margin-bottom: 50px">
        <h2>Hình thức thanh toán</h2>
    </div>
    <form action="{{URL::to('/order-place')}}" method="POST">
    {{ csrf_field() }}
        <div class="payment-options">
            <span>
                <label><input name="payment_option" value="1" type="checkbox"> Thẻ ATM</label>
            </span>
            <span>
                <label><input name="payment_option" value="2" type="checkbox"> Nhận hàng trả tiền</label>
            </span>
            <input class="btn btn-primary" value="Tiếp tục" name="send_order_place" type="submit" style="display: block">
            {{-- <span>
                <label><input type="checkbox"> Paypal</label>
            </span> --}}
        </div>
    </form>
</section> <!--/#cart_items-->

@endsection