@extends('admin.layout')

@section('title')
    Cap nhat san pham
@endsection

@section('content')
    <div class="container w-75">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="bt-3">
                <label for="" class="form-label">Ten san pham</label>
                <input type="text" name="name" id="" class="form-control" value="{{ $product->name }}">
            </div>

            <div class="bt-3">
                <label for="" class="form-label">Ma san pham</label>
                <input type="text" name="code" id="" class="form-control" value="{{ $product->code }}">
            </div>

            <div class="bt-3">
                <label for="" class="form-label">Danh muc</label>
                <select name="category_id" id="" class="form-control">
                    @foreach ($categories as $cate)
                        <option value="{{ $cate->id }}" 
                            @selected($cate->id == $product->category_id)>
                            {{ $cate->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="bt-3">
                <label for="" class="form-label">Hinh anh hien tai:</label><br>
                <img src="{{ Storage::URL($product->image) }}" width="150px" alt="{{ $product->name }}"><br><br>
                <label for="" class="form-label">Hinh anh moi (Neu muon thay doi):</label><br>
                <input type="file" name="image" id="" class="form-control">
            </div>

            <div class="bt-3">
                <label for="" class="form-label">Mo ta</label>
                <textarea name="description" rows="4" class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="bt-3">
                <label for="" class="form-label">Chat lieu</label>
                <input name="metarial" id="" class="form-control" value="{{ $product->metarial }}">
            </div>

            <div class="bt-3">
                <label for="" class="form-label">Huong dan su dung</label>
                <textarea name="instruct" rows="4" class="form-control">{{ $product->instruct }}</textarea>
            </div>

            <div class="bt-3">
                <label for="" class="form-label">Hien thi tren trang chu</label>
                <input type="checkbox" name="onpage" value="1" @checked($product->onpage)>
            </div>

            <div class="bt-3">
                <label for="" class="form-label">Hien thi tren trang chu</label>
                <input type="hidden" name="onpage" value="0">
                <input type="checkbox" name="onpage" value="1" @checked($product->onpage)>
            </div>

            <div class="bt-3">
                <button type="submit" class="btn btn-primary">Luu</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Danh sach</a>
            </div>
        </form>
        
    </div>
@endsection