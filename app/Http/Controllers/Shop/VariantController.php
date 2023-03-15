<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json([
                'message' => "Product not found"
            ], 404);
        }

        Variant::create([
            'product_id' => $product->id,
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => "Variant created!"
        ]);
    }

    public function update($id, Request $request)
    {
        $variant = Variant::find($id);
        if (!$variant) {
            return response()->json([
                'message' => "Product's variant not found"
            ], 404);
        }

        $variant->update([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => "Product's variant updated!"
        ]);
    }

    public function delete($id)
    {
        Variant::find($id)->delete();
        return response()->json([
            'message' => "Product's variant deleted!"
        ]);
    }
}
