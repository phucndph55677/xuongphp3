<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $product = Product::with(['variants.color', 'variants.size'])
            ->where('id', $id)
            ->first();

        return view('admin.products.variants.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $colors = Color::all();
        $sizes = Size::all();
        
        return view('admin.products.variants.create', compact('colors', 'sizes', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $path_image = $request->file('image')->store('images');
        }

        $data['image'] = $path_image ?? null;

        ProductVariant::query()->create($data);

        return redirect()
            ->route('admin.variants.index', $request->product_id)
            ->with('message', 'Them du lieu thanh cong');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $variant = ProductVariant::find($id);
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.variants.edit', compact('variant', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $variant = ProductVariant::find($id);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path_image = $request->file('image')->store('images');
            $data['image'] = $path_image;
        }

        // Xoa anh cu
        if (isset($path_image)) {
            if ($variant->image != null) {
                if (Storage::fileExists($variant->image)) {
                    Storage::delete($variant->image);
                }
            }
        }

        $variant->update($data);

        return redirect()->back()->with('message', 'Cap nhat du lieu thanh cong');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = ProductVariant::find($id);

        if (isset($path_image)) {
            if ($variant->image != null) {
                if (Storage::fileExists($variant->image)) {
                    Storage::delete($variant->image);
                }
            }
        }

        $variant->delete();

        return redirect()
            ->route('admin.variants.index', $variant->product_id)
            ->with('message', 'Xoa du lieu thanh cong');
    }
}
