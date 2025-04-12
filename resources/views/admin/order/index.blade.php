@extends('admin.layout')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <!-- Danh sách đơn hàng -->
    <div class="container">
        <h1>Danh sách đơn hàng</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt hàng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->pay_amount }}</td>
                        <td>{{ $statuses[$order->status] }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">Xem</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links() }}
    @endsection