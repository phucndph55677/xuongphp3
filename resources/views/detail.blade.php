@extends('layouts/app')
@section('title')
    {{ $product->name }}
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ Storage::URL($product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <form action="{{ route('cart.add') }}" method="post">
                    @csrf
                    <!--ID sản phẩm-->
                    <input type="hidden" id="product-id" value="{{ $product->id }}">
                    <h2>{{ $product->name }}</h2>
                    <p class="text-danger fw-bold price" id="product-price">Giá: {{ $product->lowest_price }} $</p>
                    <div class="color-option mt-3">
                        <strong>Màu sắc:</strong>
                        @foreach ($product->variants->unique('color') as $variant)
                            <input type="radio" id="color-{{ $variant->color->id }}" name="color"
                                value="{{ $variant->color->id }}" class="color">
                            <label for="color-{{ $variant->color->id }}"
                                style="background-color: {{ $variant->color->code }};"></label>
                        @endforeach
                    </div>

                    <div class="size-option mt-3">
                        <strong>Size:</strong>
                        @foreach ($product->variants->unique('size') as $variant)
                            <input type="radio" id="size-{{ $variant->size->id }}" name="size"
                                value="{{ $variant->size->id }}" class="size">
                            <label for="size-{{ $variant->size->id }}">{{ $variant->size->name }}</label>
                        @endforeach

                    </div>
                    <div class="mt-3"><strong>Số lượng: <span
                                id="stock">{{ $product->variants->first()->stock ?? 'Hết hàng' }}</span></strong></div>
                    <div class="mt-3"><strong>Chất liệu</strong></div>
                    <p class="mt-3">{{ $product->metarial }}</p>

                    <div><strong>Hướng dẫn sử dụng</strong></div>
                    <p class="mt-3">{{ $product->instruct }}</p>

                    <div><strong>Mô tả</strong></div>
                    <p class="m">{{ $product->description }}</p>
                    <div>
                        Số lượng: <input type="number" name="quantity" id="quantity" value="1" min="1"
                            max="10">
                    </div>
                    <input type="hidden" name="variant_id" id="variant-id" value="{{ $product->variants->first()->id }}">
                    <button class="btn btn-primary mt-4" id="addToCart">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ID sản phẩm
            let productId = document.getElementById('product-id').value;
            // Các biến chứa các phần tử class size và color
            let sizeInputs = document.querySelectorAll(".size");
            let colorInputs = document.querySelectorAll(".color");
            // Các biến chứa các phần tử id price và stock
            let priceElement = document.getElementById("product-price");
            let stockElement = document.getElementById("stock");

            let addToCart = document.getElementById("addToCart");
            let quantityInput = document.getElementById("quantity");

            // Lấy phần tử có id là variant_id
            let variantId = document.getElementById("variant-id");

            function updatePrice() {
                let selectedColor = document.querySelector(".color:checked").value;
                let selectedSize = document.querySelector(".size:checked").value;

                fetch(`/get-variant-price?product_id=${productId}&color=${selectedColor}&size=${selectedSize}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.price) {
                            priceElement.textContent = data.price.toLocaleString("vi-VN") + " ₫";
                            stockElement.textContent = data.stock;
                            //Hiển thị nút thêm vào giỏ hàng
                            addToCart.style.display = "block";
                            //thay đổi giá trị số lượng lớn nhất được phép nhập
                            quantityInput.max = data.stock;
                            //Nếu số lượng lớn hơn số lượng trong kho thì gán lại giá trị là số lượng trong kho
                            if (quantityInput.value > data.stock) {
                                quantityInput.value = data.stock;
                            }

                            //Gán giá trị cho id variant_id
                            variantId.value = data.id;
                        } else {
                            priceElement.textContent = "Liên hệ";
                            stockElement.textContent = "Hết hàng";
                            //Ẩn nút thêm vào giỏ hàng
                            addToCart.style.display = "none";
                        }
                    })
                    .catch(error => console.error("Lỗi khi lấy giá:", error));
            }

            colorInputs.forEach(input => input.addEventListener("change", updatePrice));
            sizeInputs.forEach(input => input.addEventListener("change", updatePrice));


        });

        @if (session('success'))
            alert("{{ session('success') }}");
        @endif
    </script>
@endsection