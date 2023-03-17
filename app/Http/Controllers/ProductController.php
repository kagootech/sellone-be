<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $requset)
    {
        return Product::all();
    }

    public function show($state, Request $request)
    {
        $product = Product::with('variants')->where('state', $state)->find($request->id);
        if(!$product){
            return response()->json([
                'message' => 'Product not found!'
            ], 404);
        }
        return response()->json([
            'message' => 'Product found!',
            'data' => $product
        ]);
    }
}
