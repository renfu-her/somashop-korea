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
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $products = Product::with('category')
            ->orderByDesc('created_at')
            ->get();


        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::with('children')
            ->where('parent_id', 0)
            ->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cash_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'is_hot' => 'boolean',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'content' => 'required|string',
            'sort_order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_new'] = $request->has('is_new') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_hot'] = $request->has('is_hot') ? 1 : 0;

        // 創建產品
        $product = Product::create($validated);

        // 處理圖片上傳
        if ($request->hasFile('image')) {
            $filename = $this->imageService->uploadImage(
                $request->file('image'),
                "products/{$product->id}"
            );

            // 創建產品圖片記錄
            $product->images()->create([
                'image_path' => $filename,
                'is_primary' => true,
                'sort_order' => 0
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', '商品已創建');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $specifications = ProductSpecification::orderBy('name')->get();

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'specifications'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cash_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'is_hot' => 'boolean',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'content' => 'required|string',
            'sort_order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_new'] = $request->has('is_new') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_hot'] = $request->has('is_hot') ? 1 : 0;

        // 更新產品資訊
        $product->update($validated);

        // 處理圖片上傳
        if ($request->hasFile('image')) {
            // 刪除舊圖片
            if ($product->primaryImage) {
                Storage::disk('public')->delete($product->primaryImage->full_path);
                $product->primaryImage->delete();
            }

            // 上傳新圖片
            $filename = $this->imageService->uploadImage(
                $request->file('image'),
                "products/{$product->id}"
            );

            // 創建新的產品圖片記錄
            $product->images()->create([
                'image_path' => $filename,
                'is_primary' => true,
                'sort_order' => 0
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', '商品已更新');
    }

    public function destroy(Product $product)
    {
        // 刪除產品相關的圖片
        foreach ($product->images as $image) {
            Storage::disk('public')->delete("products/{$product->id}/{$image->image_path}");
        }

        // 刪除產品
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', '商品已刪除');
    }

    public function deleteImage(Product $product)
    {
        if ($product->primaryImage) {
            Storage::disk('public')->delete($product->primaryImage->full_path);
            $product->primaryImage->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
