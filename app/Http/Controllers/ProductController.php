<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $requset)
    {
        # code...
    }

    public function show($state)
    {
        $product = Product::with('variants')->where('state', $state)->firstOrFail();
        return response()->json([
            'message' => 'Product found!',
            'data' => $product
        ]);
    }
}
