@extends('admin.layout')

@section('title')
    Them bien the
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('admin.variants.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Luu thong tin id san pham -->
            <input type="hidden" name="product_id" id="" value="{{ $id }}">

            <div class="mb-3">
                <label for="" class="form-label">Hinh anh</label>
                <input type="file" name="image" id="" class="form-control">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Mau sac</label>
                <select name="color_id" id="" class="form-control">
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Size</label>
                <select name="size_id" id="" class="form-control">
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Price</label>
                <input type="number" name="price" id="" class="form-control">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Gia giam</label>
                <input type="number" name="sale" id="" class="form-control">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">So luong</label>
                <input type="number" name="stock" id="" class="form-control">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Luu</button>
            </div>

        </form>
    </div>
@endsection