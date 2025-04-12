@extends('layouts.app')

{{-- Giả sử Controller truyền vào biến $product, $colors, $sizes --}}
@section('title', $product->name)

@section('content')
{{-- Thêm ID và data-attributes để JS có thể lấy dữ liệu --}}
<div class="container mx-auto" id="product-details-container"
     data-variants="{{ json_encode($product->variants->keyBy('id')) }}"
     data-product-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
     data-colors="{{ json_encode($colors->keyBy('id')) }}" {{-- Truyền cả object màu --}}
     data-sizes="{{ json_encode($sizes->keyBy('id')) }}" {{-- Truyền cả object size --}}
>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Phần Hình ảnh --}}
        <div>
            {{-- Ảnh chính - Thêm ID --}}
            <img id="main-product-image" src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.png') }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-md mb-4">

            {{-- Ảnh gallery nhỏ của các variants (nếu có) --}}
            <div class="flex space-x-2 overflow-x-auto">
                {{-- Ảnh gốc của product (nếu có) --}}
                 @if($product->image)
                 <img src="{{ asset('storage/' . $product->image) }}"
                      alt="{{ $product->name }} - default"
                      class="w-20 h-20 object-cover border rounded cursor-pointer hover:border-blue-500 product-thumbnail"
                      data-image-src="{{ asset('storage/' . $product->image) }}"> {{-- Thêm class và data-src --}}
                 @endif
                 {{-- Ảnh của variants --}}
                @foreach($product->variants as $variant)
                    @if($variant->image)
                    <img src="{{ asset('storage/' . $variant->image) }}"
                         alt="Variant Image {{ $variant->id }}"
                         class="w-20 h-20 object-cover border rounded cursor-pointer hover:border-blue-500 product-thumbnail variant-thumbnail"
                         data-image-src="{{ asset('storage/' . $variant->image) }}"
                         data-variant-id="{{ $variant->id }}"> {{-- Thêm class và data-src/data-variant-id --}}
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Phần Thông tin và Lựa chọn --}}
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">Mã SP: {{ $product->code }}</p>

            {{-- Giá sản phẩm - Thêm ID --}}
            <div id="price-display" class="mb-4 text-2xl font-bold">
                 {{-- JS sẽ cập nhật nội dung này --}}
                 <span class="text-gray-600">Vui lòng chọn biến thể</span>
            </div>

            <p class="text-gray-700 mb-6">{{ $product->description }}</p>

            <form id="add-to-cart-form" action="{{-- route('cart.add') --}}" method="POST">
                @csrf
                {{-- Input ẩn để lưu product_variant_id được chọn - Thêm ID --}}
                <input type="hidden" name="product_variant_id" id="selected_product_variant_id" value="">

                {{-- Lựa chọn Màu sắc --}}
                @if($colors->count() > 0)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Màu sắc:</label>
                    <div class="flex flex-wrap gap-2" id="color-options">
                        @foreach($colors as $color)
                        <button type="button"
                                class="w-8 h-8 rounded-full border border-gray-300 focus:outline-none color-option-button"
                                data-color-id="{{ $color->id }}"
                                title="{{ $color->name }}"
                                style="background-color: {{ $color->code ?? '#ffffff' }}; {{ !$color->code ? 'border-color: #000;' : '' }}">
                                {{-- Hiển thị tên nếu ko có code màu --}}
                                @if(!$color->code) <span class="text-xs text-black mix-blend-difference">{{$color->name}}</span> @endif
                        </button>
                        @endforeach
                    </div>
                    {{-- Input ẩn này không cần thiết nữa nếu dùng JS quản lý state --}}
                    {{-- <input type="hidden" name="color_id" id="selected_color_id"> --}}
                </div>
                @endif

                {{-- Lựa chọn Size --}}
                 @if($sizes->count() > 0)
                 <div class="mb-4">
                     <label class="block text-sm font-medium text-gray-700 mb-1">Size:</label>
                     <div class="flex flex-wrap gap-2" id="size-options">
                        @foreach($sizes as $size)
                            <button type="button"
                                    class="px-3 py-1 border rounded focus:outline-none hover:border-blue-500 size-option-button bg-gray-200 text-gray-800"
                                    data-size-id="{{ $size->id }}">
                                {{ $size->name }}
                            </button>
                        @endforeach
                     </div>
                     {{-- Input ẩn này không cần thiết nữa nếu dùng JS quản lý state --}}
                     {{-- <input type="hidden" name="size_id" id="selected_size_id"> --}}
                 </div>
                 @endif

                {{-- Hiển thị số lượng tồn kho - Thêm ID --}}
                <div id="stock-status" class="mb-4 text-sm">
                    @if($colors->count() > 0 || $sizes->count() > 0)
                         <span class="text-gray-500">Vui lòng chọn màu sắc/size</span>
                     @endif
                     {{-- JS sẽ cập nhật nội dung này nếu chọn được variant --}}
                </div>

                {{-- Chọn Số lượng --}}
                <div class="mb-6">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Số lượng:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                           class="w-20 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           disabled {{-- Disable ban đầu --}}
                           >
                </div>

                {{-- Nút Thêm vào giỏ hàng - Thêm ID --}}
                <button type="submit" id="add-to-cart-button"
                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 disabled:bg-gray-400 opacity-50 cursor-not-allowed"
                        disabled {{-- Disable ban đầu --}}
                        >
                    Thêm vào giỏ hàng
                </button>
            </form>

            {{-- Thông tin thêm: Chất liệu, Hướng dẫn --}}
            <div class="mt-8 pt-6 border-t">
                 {{-- Giữ nguyên phần này --}}
                @if($product->material)
                <div class="mb-4">
                    <h4 class="font-semibold mb-1">Chất liệu:</h4>
                    <p class="text-gray-600">{{ $product->material }}</p>
                </div>
                @endif
                @if($product->instruct)
                <div>
                    <h4 class="font-semibold mb-1">Hướng dẫn bảo quản:</h4>
                    <p class="text-gray-600 whitespace-pre-line">{{ $product->instruct }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
     {{-- Phần mô tả đầy đủ, đánh giá sản phẩm (tùy chọn) --}}
     {{-- <div class="mt-12 border-t pt-8"> ... </div> --}}
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('product-details-container');
        if (!container) return; // Thoát nếu không tìm thấy container

        // Lấy dữ liệu từ data attributes
        const variantsData = JSON.parse(container.dataset.variants || '{}');
        const productImageDefault = container.dataset.productImage || '';
        const colorsData = JSON.parse(container.dataset.colors || '{}');
        const sizesData = JSON.parse(container.dataset.sizes || '{}');
        const variantsArray = Object.values(variantsData); // Chuyển object thành mảng để dễ lặp

        // Các phần tử DOM
        const mainImage = document.getElementById('main-product-image');
        const priceDisplay = document.getElementById('price-display');
        const stockStatus = document.getElementById('stock-status');
        const quantityInput = document.getElementById('quantity');
        const addToCartButton = document.getElementById('add-to-cart-button');
        const hiddenVariantInput = document.getElementById('selected_product_variant_id');
        const colorOptionsContainer = document.getElementById('color-options');
        const sizeOptionsContainer = document.getElementById('size-options');
        const colorButtons = colorOptionsContainer ? colorOptionsContainer.querySelectorAll('.color-option-button') : [];
        const sizeButtons = sizeOptionsContainer ? sizeOptionsContainer.querySelectorAll('.size-option-button') : [];
        const thumbnailImages = container.querySelectorAll('.product-thumbnail');

        // Trạng thái hiện tại
        let selectedColorId = null;
        let selectedSizeId = null;
        let selectedVariant = null;
        let hasColors = colorButtons.length > 0;
        let hasSizes = sizeButtons.length > 0;

        // --- Hàm Utility ---
        function formatCurrency(amount) {
            if (amount === null || amount === undefined) return '';
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }

        // Tìm biến thể phù hợp
        function findSelectedVariant() {
            selectedVariant = null; // Reset
            for (const variant of variantsArray) {
                 // Điều kiện khớp:
                 // 1. Không có màu HOẶC màu khớp
                 // 2. Không có size HOẶC size khớp
                const colorMatch = !hasColors || variant.color_id == selectedColorId;
                const sizeMatch = !hasSizes || variant.size_id == selectedSizeId;

                if (colorMatch && sizeMatch) {
                     // Đã chọn đủ thông tin nếu cần (hoặc không cần chọn gì)
                     if ((hasColors && selectedColorId !== null) || !hasColors) {
                          if ((hasSizes && selectedSizeId !== null) || !hasSizes) {
                            selectedVariant = variant;
                            break;
                          }
                     }
                }
            }
            // console.log("Selected Variant:", selectedVariant);
             updateUI(); // Cập nhật giao diện sau khi tìm được variant
        }

         // Cập nhật giao diện dựa trên selectedVariant
         function updateUI() {
            if (selectedVariant) {
                // Cập nhật giá
                let priceHtml = '';
                if (selectedVariant.sale && parseFloat(selectedVariant.sale) < parseFloat(selectedVariant.price)) {
                    priceHtml = `<span class="text-red-500">${formatCurrency(selectedVariant.sale)}</span>
                                 <span class="text-gray-500 line-through ml-2 text-xl">${formatCurrency(selectedVariant.price)}</span>`;
                } else {
                    priceHtml = `<span class="text-blue-600">${formatCurrency(selectedVariant.price)}</span>`;
                }
                priceDisplay.innerHTML = priceHtml;

                // Cập nhật ảnh chính (ưu tiên ảnh variant nếu có)
                mainImage.src = selectedVariant.image ? `/storage/${selectedVariant.image}` : productImageDefault || '/images/placeholder.png';

                // Cập nhật trạng thái kho
                if (selectedVariant.stock > 0) {
                    stockStatus.innerHTML = `<span class="text-green-600">Còn hàng (${selectedVariant.stock} sản phẩm)</span>`;
                    quantityInput.max = selectedVariant.stock;
                    quantityInput.disabled = false;
                    addToCartButton.disabled = false;
                    addToCartButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    stockStatus.innerHTML = `<span class="text-red-600">Hết hàng</span>`;
                    quantityInput.max = 0;
                    quantityInput.disabled = true;
                    addToCartButton.disabled = true;
                     addToCartButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
                quantityInput.value = 1; // Reset số lượng về 1
                hiddenVariantInput.value = selectedVariant.id; // Lưu ID variant đã chọn

            } else {
                // Reset về trạng thái chưa chọn
                mainImage.src = productImageDefault || '/images/placeholder.png'; // Ảnh mặc định
                priceDisplay.innerHTML = `<span class="text-gray-600">Vui lòng chọn biến thể</span>`;
                 if(hasColors || hasSizes){
                    stockStatus.innerHTML = `<span class="text-gray-500">Vui lòng chọn màu sắc/size</span>`;
                 } else {
                    stockStatus.innerHTML = ''; // Không có gì để chọn
                 }
                quantityInput.value = 1;
                quantityInput.max = 1;
                quantityInput.disabled = true;
                addToCartButton.disabled = true;
                addToCartButton.classList.add('opacity-50', 'cursor-not-allowed');
                hiddenVariantInput.value = '';
            }
            updateAttributeStates(); // Cập nhật trạng thái của các nút màu/size
        }

        // Cập nhật trạng thái active/disabled của các nút màu/size
        function updateAttributeStates() {
            // Cập nhật nút màu
            colorButtons.forEach(button => {
                const colorId = button.dataset.colorId;
                // Active nếu là màu đang chọn
                if (colorId == selectedColorId) {
                    button.classList.add('ring-2', 'ring-offset-1', 'ring-blue-500');
                } else {
                    button.classList.remove('ring-2', 'ring-offset-1', 'ring-blue-500');
                }

                // Disable nếu không có variant nào phù hợp với màu này VÀ size đang chọn (nếu size đã được chọn)
                 let isAvailable = isAttributeAvailable('color', colorId, selectedSizeId);
                 button.disabled = !isAvailable;
                 if (!isAvailable) {
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                 } else {
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                 }
            });

            // Cập nhật nút size
            sizeButtons.forEach(button => {
                const sizeId = button.dataset.sizeId;
                // Active nếu là size đang chọn
                if (sizeId == selectedSizeId) {
                    button.classList.add('ring-2', 'ring-blue-500', 'bg-blue-100'); // Thêm style active
                     button.classList.remove('bg-gray-200');
                } else {
                    button.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-100');
                    button.classList.add('bg-gray-200');
                }

                 // Disable nếu không có variant nào phù hợp với size này VÀ màu đang chọn (nếu màu đã được chọn)
                 let isAvailable = isAttributeAvailable('size', sizeId, selectedColorId);
                 button.disabled = !isAvailable;
                  if (!isAvailable) {
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                 } else {
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                 }
            });

            // Cập nhật border cho ảnh thumbnail được chọn (dựa vào variant)
            thumbnailImages.forEach(img => {
                const variantId = img.dataset.variantId;
                if (selectedVariant && variantId == selectedVariant.id) {
                    img.classList.add('border-blue-500', 'border-2');
                } else {
                    img.classList.remove('border-blue-500', 'border-2');
                }
                 // Handle default image thumbnail selection (less precise, based on src matching main image)
                 if(!variantId && mainImage.src === img.dataset.imageSrc && !selectedVariant?.image){
                    img.classList.add('border-blue-500', 'border-2');
                 } else if(!variantId) {
                    img.classList.remove('border-blue-500', 'border-2');
                 }
            });
        }

        // Kiểm tra xem một thuộc tính (màu/size) có khả dụng với lựa chọn còn lại không
        function isAttributeAvailable(attributeType, attributeId, otherSelectedId) {
            const otherAttributeType = attributeType === 'color' ? 'size' : 'color';
            const hasOtherAttribute = otherAttributeType === 'color' ? hasColors : hasSizes;

             for (const variant of variantsArray) {
                 // Kiểm tra xem variant này có khớp với attributeId đang xét không
                 if (variant[attributeType + '_id'] == attributeId) {
                     // Nếu không có thuộc tính kia HOẶC thuộc tính kia chưa chọn HOẶC thuộc tính kia khớp với variant này
                     if (!hasOtherAttribute || otherSelectedId === null || variant[otherAttributeType + '_id'] == otherSelectedId) {
                         return true; // Tìm thấy ít nhất 1 variant khả dụng
                     }
                 }
             }
            return false; // Không tìm thấy variant nào khả dụng
        }


        // --- Xử lý sự kiện ---
        if (colorOptionsContainer) {
            colorOptionsContainer.addEventListener('click', function(event) {
                const button = event.target.closest('.color-option-button');
                if (button && !button.disabled) {
                    selectedColorId = button.dataset.colorId;
                    // console.log("Selected Color ID:", selectedColorId);
                    // Nếu size không còn phù hợp -> reset size (hoặc tìm size phù hợp đầu tiên?)
                    if (hasSizes && selectedSizeId !== null && !isAttributeAvailable('size', selectedSizeId, selectedColorId)) {
                         selectedSizeId = null; // Reset size nếu không hợp lệ
                         // Tùy chọn: Tìm và chọn size đầu tiên hợp lệ với màu mới này
                         // for(const sizeBtn of sizeButtons){
                         //     if(isAttributeAvailable('size', sizeBtn.dataset.sizeId, selectedColorId)){
                         //         selectedSizeId = sizeBtn.dataset.sizeId;
                         //         break;
                         //     }
                         // }
                    }
                    findSelectedVariant(); // Tìm variant và cập nhật UI
                }
            });
        }

         if (sizeOptionsContainer) {
             sizeOptionsContainer.addEventListener('click', function(event) {
                 const button = event.target.closest('.size-option-button');
                 if (button && !button.disabled) {
                    selectedSizeId = button.dataset.sizeId;
                    // console.log("Selected Size ID:", selectedSizeId);
                     // Tương tự, có thể reset màu nếu không còn phù hợp
                     if (hasColors && selectedColorId !== null && !isAttributeAvailable('color', selectedColorId, selectedSizeId)) {
                          selectedColorId = null; // Reset màu nếu không hợp lệ
                     }
                     findSelectedVariant(); // Tìm variant và cập nhật UI
                 }
            });
        }

        // Xử lý click ảnh thumbnail
         thumbnailImages.forEach(img => {
             img.addEventListener('click', function() {
                 const imageSrc = this.dataset.imageSrc;
                 const variantId = this.dataset.variantId;

                 if (imageSrc) {
                     mainImage.src = imageSrc; // Cập nhật ảnh chính ngay lập tức
                 }

                  // Nếu thumbnail này tương ứng với 1 variant cụ thể, hãy chọn variant đó
                 if (variantId && variantsData[variantId]) {
                     selectedVariant = variantsData[variantId];
                     selectedColorId = selectedVariant.color_id;
                     selectedSizeId = selectedVariant.size_id;
                     updateUI(); // Cập nhật toàn bộ UI theo variant vừa chọn từ ảnh
                 } else if (!variantId && imageSrc === productImageDefault) {
                     // Nếu click ảnh gốc và chưa chọn variant, không làm gì thêm về state
                     // Nếu đã chọn variant, click ảnh gốc chỉ đổi ảnh, không đổi state
                     updateAttributeStates(); // Chỉ cập nhật border thumbnail
                 }
             });
         });

        // --- Khởi tạo ---
         function initialize() {
            // Nếu chỉ có 1 variant, tự động chọn
            if (variantsArray.length === 1) {
                selectedVariant = variantsArray[0];
                selectedColorId = selectedVariant.color_id;
                selectedSizeId = selectedVariant.size_id;
            }
            // Nếu không có màu và size (chỉ có 1 variant tổng thể)
            else if (!hasColors && !hasSizes && variantsArray.length > 0) {
                 selectedVariant = variantsArray[0]; // Chọn variant duy nhất
            }

             updateUI(); // Cập nhật giao diện lần đầu
         }

         initialize();

    });
</script>
@endpush