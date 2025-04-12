@extends('admin.layout')

@section('title')
    Danh sach bien the cua san pham: {{ $product->name }}
@endsection

@section('content')
    <div class="container">
        <h3>
            Bien the cua san pham: {{ $product->name }}
        </h3>
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#ID</th>
                <th scope="col">Hinh anh</th>
                <th scope="col">Mau sac</th>
                <th scope="col">Size</th>
                <th scope="col">So luong</th>
                <th scope="col">Don gia</th>
                <th>
                    <a href="{{ route('admin.variants.create', $product->id) }}" class="btn btn-primary">Them moi</a>
                </th>
              </tr>
            </thead>

            <tbody>
                @foreach ($product->variants as $variant)
                    <tr>
                        <th scope="row">{{ $variant->id }}</th>
                        <td>
                            <img src="{{ Storage::URL($variant->image) }}" width="100px" alt="Hinh anh">
                        </td>
                        <td>{{ $variant->color->name }}</td>
                        <td>{{ $variant->size->name }}</td>
                        <td>{{ $variant->stock }}</td>
                        <td>{{ $variant->price }}</td>
                        <td>
                            <a href="{{ route('admin.variants.edit', $variant->id) }}" class="btn btn-warning">Sua</a>

                            <form class="d-inline" action="{{ route('admin.variants.destroy', $variant->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger" onclick="return confirm('Ban co muon xoa khong?')">Xoa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach           
            </tbody>
          </table> 
    </div>
@endsection