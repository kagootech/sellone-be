<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        // Create product must have shop
        if ($user->shop) {

            $request->only(['image', 'name', 'detail', 'variants']);

            $category = Category::find($request->category_id);

            if (!$category) {
                return response()->json([
                    'message' => 'Invalid category, not found!'
                ], 404);
            }

            $state = str_replace(' ', '-', $request->name);
            $state = strtolower($state);

            $product = Product::create([
                'shop_id' => $user->shop->id,
                'category_id' => $category->id,
                'image' => $request->image,
                'state' => $state,
                'name' => $request->name,
                'detail' => $request->detail
            ]);

            if ($product) {

                return response()->json([
                    'message' => 'Product uploaded!',
                    'data' => Product::with('variants')->find($product->id)
                ]);
            }
        }

        return response()->json([
            'message' => 'Please register your shop!'
        ]);
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        } else {

            $request->only(['image', 'name', 'detail', 'variants']);

            $category = Category::find($request->category_id);

            if (!$category) {
                return response()->json([
                    'message' => 'Invalid category, not found!'
                ], 404);
            }

            $state = str_replace(' ', '-', $request->name);
            $state = strtolower($state);

            $productId = $product->id;
            $updateProduct = $product->update([
                'category_id' => $category->id,
                'image' => $request->image,
                'state' => $state,
                'name' => $request->name,
                'detail' => $request->detail
            ]);

            return response()->json([
                'message' => 'Product updated!',
                'data' => Product::with('variants')->find($productId)
            ]);
        }
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        Variant::where('product_id', $id)->delete();

        return response()->json([
            'message' => 'Product deleted!'
        ]);
    }
}
