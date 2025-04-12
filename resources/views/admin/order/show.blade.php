@extends('admin.layout')

@section('title')
    Chi tiết đơn hàng
@endsection
@section('content')
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Hóa Đơn {{ $order->id }}</h4>
                <small>Ngày đặt: {{ $order->created_at }}</small>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Thông tin khách hàng</h5>
                        <p class="mb-1"><strong>Họ tên:</strong> {{ $order->user->name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $order->email }}</p>
                        <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                        <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h5>Trạng thái đơn hàng</h5>
                        <span class="badge bg-success fs-6">{{ $statuses[$order->status] }}</span>
                    </div>
                </div>

                <h5 class="mb-3">Danh sách sản phẩm</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Màu</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_details as $item)
                                <tr>
                                    <td>
                                        <img src="{{ Storage::URL($item->product_variant->image) }}" width="90"
                                            alt="">
                                    </td>
                                    <td>{{ $item->product_variant->product->name }}</td>
                                    <td>{{ $item->product_variant->color->name }}</td>
                                    <td>{{ $item->product_variant->size->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price }} đ</td>
                                    <td>{{ $item->quantity * $item->price }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tạm tính:</span>
                                <strong>{{ $order->total }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Phí vận chuyển:</span>
                                <strong>30,000₫</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tổng cộng:</span>
                                <strong class="text-danger fs-5">{{ $order->pay_amount }}₫</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Phương thức thanh toán:</span>
                                <strong>{{ $order->payment }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    <h6>Ghi chú:</h6>
                    <p>{{ $item->note }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection