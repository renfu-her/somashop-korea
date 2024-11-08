<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function edit($id)
    {
        $product = Product::with('images')->where('id', $id)->first();
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|max:2048',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // 只存檔名
                $filename = Str::uuid() . '.webp';

                // 創建 ImageManager 實例
                $manager = new ImageManager(new Driver());
                $img = $manager->read($image);
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                
                $img->toWebp(90);

                // 儲存圖片
                Storage::disk('public')->put(
                    "products/{$product->id}/{$filename}",
                    $img->encode()
                );

                // 資料庫只存檔名
                $product->images()->create([
                    'image_path' => $filename,
                    'is_primary' => $index === 0,
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', '商品已創建');
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'category_id' => 'exists:categories,id',
            'images.*' => 'nullable|image|max:2048',
            'is_active' => 'boolean'
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);

        if ($request->hasFile('images')) {
            $maxOrder = $product->images()->max('sort_order') ?? -1;

            foreach ($request->file('images') as $image) {
                // 只存檔名
                $filename = Str::uuid() . '.webp';

                // 創建 ImageManager 實例
                $manager = new ImageManager(new Driver());
                $img = $manager->read($image);
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->toWebp(90);

                // 儲存圖片
                Storage::disk('public')->put(
                    "products/{$product->id}/{$filename}",
                    $img->encode()
                );

                // 資料庫只存檔名
                $product->images()->create([
                    'image_path' => $filename,
                    'is_primary' => false,
                    'sort_order' => ++$maxOrder
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', '商品已更新');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', '商品已刪除');
    }
}
