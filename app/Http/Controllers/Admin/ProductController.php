<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Services\ImageService;


class ProductController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $products = Product::with('category')->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::with('children')
            ->where('parent_id', 0)
            ->get();
        return view('admin.products.create', compact('categories'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $specifications = ProductSpecification::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'specifications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'cash_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_new'] = $request->has('is_new') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        
        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = $this->imageService->uploadImage(
                    $image, 
                    "products/{$product->id}"
                );

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


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'cash_price' => 'nullable|numeric|min:0',
            'stock' => 'integer|min:0',
            'category_id' => 'exists:categories,id',
            'images.*' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_new'] = $request->has('is_new') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $product->update($validated);

        if ($request->hasFile('images')) {
            $maxOrder = $product->images()->max('sort_order') ?? -1;

            foreach ($request->file('images') as $image) {
                $filename = $this->imageService->uploadImage(
                    $image, 
                    "products/{$product->id}"
                );

                $product->images()->create([
                    'image_path' => $filename,
                    'is_primary' => false,
                    'sort_order' => ++$maxOrder
                ]);
            }
        }

        // $specs = $request->input('specs', []);
        
        // $product->specs()->sync(
        //     collect($specs)->mapWithKeys(function ($id) {
        //         return [$id => ['is_active' => true]];
        //     })
        // );

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
