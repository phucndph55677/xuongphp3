
@foreach ($category->products as $product)
    <div>
        <div>Ten san pham: <strong>{{ $product->name }}</strong></div>
        <div>Ten danh muc: <strong>{{ $category->name }}</strong></div>
    </div>
    <br>
@endforeach