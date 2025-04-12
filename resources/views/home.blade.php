@extends('layouts/app')

@section('title')
    Shop ban hang thoi trang
@endsection

@section('content')
<div class="container mt-5" id="products">
    <h2 class="text-center mb-4">Sản Phẩm Nổi Bật</h2>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ Storage::URL($product->image) }}" class="card-img-top" alt="Sản phẩm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="text-danger fw-bold">{{ $product->lowest_price ?? '0' }} $</p>
                        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary">Xem Thêm</a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection