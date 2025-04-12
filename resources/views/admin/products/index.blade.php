@extends('admin.layout')

@section('title')
    Danh sach san pham
@endsection

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#ID</th>
                <th scope="col">Ten san pham</th>
                <th scope="col">Hinh anh</th>
                <th scope="col">Noi bat</th>
                <th scope="col">Danh muc</th>
                <th scope="col">Ngay tao</th>
                <th>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Them moi</a>
                </th>
              </tr>
            </thead>

            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name }}</td>
                        <td>
                            <img src="{{ Storage::URL($product->image) }}" width="100px" alt="Hinh anh">
                        </td>
                        <td>
                            {{ $product->onpage ? 'Trang chu' : '' }}
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            {{ $product->created_at }}
                        </td>
                        <td>
                            <a href="{{ route('admin.variants.index', $product->id) }}" class="btn btn-info">Bien the</a>

                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Sua</a>

                            <form class="d-inline" action="{{ route('admin.products.destroy', $product->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger" onclick="return confirm('Ban co muon xoa khong?')">Xoa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach           
            </tbody>
          </table> 
          {{ $products->links() }}    
    </div>
@endsection