@foreach ($products as $product)
    <div>
        <div>ID: {{ $product->id }}</div>
        <div>Ten san pham: {{ $product->name }}</div>
        <div>Ten danh muc: {{ $product->category->name }}</div>
        @foreach ($product->variants as $variant)
            <div>
                <div>Color: {{ $variant->color->name }}</div>
                <div>Color Code: {{ $variant->color->code }}</div>
                <div>Size: {{ $variant->size->name }}</div>
            </div>
        @endforeach
    </div>
    <hr>
@endforeach