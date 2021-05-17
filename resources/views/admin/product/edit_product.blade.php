@extends('admin_layout');
@section('admin_content')
<div class="form-w3layouts">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật sản phẩm
                </header>
                <div class="panel-body">
                    {{-- @foreach($edit_product as $edit_product) --}}
                        <div class="position-center">
                            <?php
                                $message = Session::get('message');
                                if($message){
                                    echo $message;
                                    Session::put('message', null);
                                }
                            ?>
                            <form role="form" method="POST" action="{{URL::to('/update-product/'.$edit_product->product_id)}}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="product_name" value="{{$edit_product->product_name}}" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Danh mục</label>
                                    <select name="cat_id" class="form-control input-sm m-bot15">
                                        @foreach ($cat_product as $cat)
                                            @if($cat->cat_product_id==$edit_product->cat_id)
                                                <option selected value="{{$cat->cat_product_id}}">{{$cat->cat_product_name}}</option>
                                            @else
                                                <option  value="{{$cat->cat_product_id}}">{{$cat->cat_product_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thương hiệu</label>
                                    <select name="brand_id" class="form-control input-sm m-bot15">
                                        @foreach ($brand_product as $brand)
                                            @if($brand->brand_product_id==$edit_product->brand_id)
                                                <option selected value="{{$brand->brand_product_id}}">{{$brand->brand_product_name}}</option>
                                            @else
                                                <option value="{{$brand->brand_product_id}}">{{$brand->brand_product_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá</label>
                                    <input type="text" name="product_price" value="{{$edit_product->product_price}}" class="form-control" id="exampleInputEmail1" placeholder="Giá">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" placeholder="">
                                    <img src="{{URL::to('public/upload/product/'.$edit_product->product_image) }}" width="100px" height="100px" alt="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="5" type="text" name="product_desc" class="form-control" id="pro_ckeditor1" placeholder="Mô tả">
                                        {{$edit_product->product_desc}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="product_status" class="form-control input-sm m-bot15">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                                <button type="submit" name="update_product" class="btn btn-info">Cập nhật</button>
                            </form>
                        </div>
                    {{-- @endforeach --}}
                </div>
            </section>
        </div>
    </div>
</div>
@endsection