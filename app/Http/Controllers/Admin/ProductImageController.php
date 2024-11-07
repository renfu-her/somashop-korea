<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductImageController extends Controller
{
    // 獲取產品的所有圖片
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $images = $product->images()->orderBy('sort_order')->get();

        return response()->json([
            'status' => 'success',
            'data' => $images
        ]);
    }

    // 上傳新圖片
    public function store(Request $request, $productId)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048',
            'is_primary' => 'boolean'
        ]);

        $product = Product::findOrFail($productId);
        $uploadedImages = [];

        DB::transaction(function () use ($request, $product, &$uploadedImages) {
            // 如果設置為主圖，先將其他圖片設為非主圖
            if ($request->input('is_primary', false)) {
                $product->images()->update(['is_primary' => false]);
            }

            // 獲取當前最大的排序號
            $maxOrder = $product->images()->max('sort_order') ?? 0;

            foreach ($request->file('images') as $image) {
                $path = $image->store('products/' . $product->id, 'public');
                
                $productImage = $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $request->input('is_primary', false),
                    'sort_order' => ++$maxOrder
                ]);

                $uploadedImages[] = $productImage;
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => '圖片上傳成功',
            'data' => $uploadedImages
        ], 201);
    }

    // 更新圖片資訊
    public function update(Request $request, $productId, $imageId)
    {
        $request->validate([
            'is_primary' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $product = Product::findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);

        DB::transaction(function () use ($request, $product, $image) {
            if ($request->has('is_primary') && $request->is_primary) {
                $product->images()->where('id', '!=', $image->id)
                    ->update(['is_primary' => false]);
            }

            $image->update($request->only(['is_primary', 'sort_order']));
        });

        return response()->json([
            'status' => 'success',
            'message' => '圖片資訊已更新',
            'data' => $image
        ]);
    }

    // 刪除圖片
    public function destroy($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);

        // 刪除實際檔案
        Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return response()->json([
            'status' => 'success',
            'message' => '圖片已刪除'
        ]);
    }

    // 批量更新圖片排序
    public function updateOrder(Request $request, $productId)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*.id' => 'required|exists:product_images,id',
            'images.*.sort_order' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($productId);

        DB::transaction(function () use ($request, $product) {
            foreach ($request->images as $imageData) {
                $product->images()
                    ->where('id', $imageData['id'])
                    ->update(['sort_order' => $imageData['sort_order']]);
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => '圖片排序已更新'
        ]);
    }

    // 設置主圖
    public function setPrimary($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        
        DB::transaction(function () use ($product, $imageId) {
            // 將所有圖片設為非主圖
            $product->images()->update(['is_primary' => false]);
            
            // 設置新的主圖
            $product->images()->findOrFail($imageId)->update(['is_primary' => true]);
        });

        return response()->json([
            'status' => 'success',
            'message' => '主圖已更新'
        ]);
    }
}
