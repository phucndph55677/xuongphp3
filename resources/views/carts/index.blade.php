@extends('layouts/app')
@section('title')
    Giỏ hàng
@endsection
@section('content')
    <div class="container my-5">
        <h2 class="mb-4 text-center">Giỏ hàng của bạn</h2>

        <form action="/cap-nhat-gio-hang" method="POST">
            <!-- CSRF nếu dùng Laravel -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered cart-table">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Kích thước</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sản phẩm 1 -->
                        @foreach ($cart as $product)
                            <tr>
                                <td>{{ $product['id'] }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td><span class="badge bg-primary">{{ $product['color'] }}</span></td>
                                <td>{{ $product['size'] }}</td>
                                <td>
                                    <input type="number" name="quantities[{{ $product['id'] }}]"
                                        class="form-control text-center" value="{{ $product['quantity'] }}" min="1">
                                    <input type="hidden" name="variant_ids[]" value="{{ $product['id'] }}">
                                </td>
                                <td>{{ number_format($product['price'] * $product['quantity'], 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach


                        <!-- Tổng cộng -->
                        <tr class="table-secondary">
                            <td colspan="5" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td><strong>{{ $total }} đ</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/san-pham" class="btn btn-outline-secondary">Tiếp tục mua hàng</a>
                <div>
                    <button type="submit" class="btn btn-primary">Cập nhật số lượng</button>
                    <a href="{{ route('cart.checkout') }}" class="btn btn-success">Thanh toán</a>
                </div>
            </div>
        </form>
    </div>
@endsection