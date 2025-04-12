<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        //Lấy toàn bộ danh sách sản phẩm
        // $products = Product::all();

        //Phân trang
        // $products = Product::query()
        //     ->orderBy('id', 'desc')
        //     ->paginate(10);

        //Điều kiện
        $products = Product::query()
            ->where('category_id', 2)
            ->where('name', 'LIKE', '%et%')
            ->get();

        //Lấy 1 phần tử theo id
        $products = Product::query()->find(99);

        $category = Category::find(2);
        // $products = $category->products;
        //Lấy ra các sản phẩm có danh mục là 2

        // return $category->product; // 1 - 1

        //sử dụng quan hệ 1 - n
        return view('test', compact('category'));
    }

    public function list()
    {
        //Sử dụng bình thường
        // $products = Product::query()->paginate(10);

        //Sử dụng kỹ thuật eager loading
        // $products = Product::with('category')
        //     ->paginate(10);


        $products = Product::with(['variants.color', 'variants.size'])
            ->paginate(10);
        // return $products;
        return view('test2', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['variants.color', 'variants.size'])
            ->find($id);

        return view('detail', compact('product'));
    }

    public function getVariantPrice(Request $request)
    {
        $variant = ProductVariant::where('product_id', $request->product_id)
            ->where('color_id', $request->color)
            ->where('size_id', $request->size)
            ->first();
        // return $variant;
        if ($variant) {
            return response()->json($variant);
        } else {
            return response()->json(['error' => 'Không tìm thấy biến thể'], 404);
        }
    }
}