<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->only(['name']);
        $shop = Shop::create([
            'user_id' => $request->user()->id,
            'name' => $data['name']
        ]);
        if($shop){
            return response()->json([
                'message' => 'Shop registered',
            ]);
        } else {
            return response()->json([
                'message' => 'Failed register shop',
            ], 500);
        }
    }
}
