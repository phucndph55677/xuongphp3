@extends('admin.layout')

@section('title')
    Cpa nhat bien the
@endsection

@section('content')
    <div class="container">
        @session('message')
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endsession

        <form action="{{ route('admin.variants.update', $variant->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="" class="form-label">Hinh anh cu:</label><br>
                <img src="{{ Storage::URL($variant->image) }}" width="100px"><br><br>
                <label for="" class="form-label">Hinh anh moi (Neu muon thay doi):</label><br>
                <input type="file" name="image" id="" class="form-control">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Mau sac</label>
                <select name="color_id" id="" class="form-control">
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}" 
                            @selected($color->id == $variant->color_id)>
                            {{ $color->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Size</label>
                <select name="size_id" id="" class="form-control">
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}"
                            @selected($size->id == $variant->size_id)>
                            {{ $size->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Price</label>
                <input type="number" name="price" id="" class="form-control" value="{{ $variant->price }}">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Gia giam</label>
                <input type="number" name="sale" id="" class="form-control" value="{{ $variant->sale }}">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">So luong</label>
                <input type="number" name="stock" id="" class="form-control" value="{{ $variant->stock }}">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Cap nhat</button>
                <a href="{{ route('admin.variants.index', $variant->product_id) }}" class="btn btn-primary">Danh sach</a>
            </div>

        </form>
    </div>
@endsection