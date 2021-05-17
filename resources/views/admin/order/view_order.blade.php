@extends('admin_layout');
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông tin khách hàng
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Tên khách hàng</th>
              <th>Địa chỉ giao hàng</th>
              <th>Số điện thoại</th>
              <th>Email</th>
              <th>Ngày đặt hàng</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order_by_id as $order_by_id)
              <tr>
                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                <td>{{ $order_by_id->shipping_name }}</td>
                <td>{{ $order_by_id->shipping_address }}</td>
                <td>{{ $order_by_id->shipping_phone }}</td>
                <td>{{ $order_by_id->shipping_email }}</td>
                <td>{{ $order_by_id->order_date }}</td>
              </tr>     
            @endforeach       
          </tbody>
        </table>
      </div>
    </div>
</div>
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Chi tiết đơn hàng
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Tên sản phẩm</th>
              <th>Hình ảnh</th>
              <th>Số lượng</th>
              <th>Đơn giá</th>
              <th>Thành tiền</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{ $order_by_id->product_name }}</td>
              <td><img src="{{ URL::to('/public/upload/product/'.$order_by_id->product_image) }}" width="80px" height="80px" alt=""></td>
              <td>{{ $order_by_id->product_sales_qty }}</td>
              <td>{{ $order_by_id->product_price }}</td>
              <td>{{ $order_by_id->order_total }}</td>             
            </tr> 
          </tbody>
        </table>
      </div>
    </div>
</div>

@endsection