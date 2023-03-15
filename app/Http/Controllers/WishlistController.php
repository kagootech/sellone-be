<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Wishlists shown',
            'data' => Wishlist::with('product')->where('user_id', $request->user()->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $liked = Wishlist::where('user_id', $request->user()->id)->where('product_id', $request->product_id);
        if ($liked->count()) {

            Wishlist::find($liked->first()->id)->delete();
            return response()->json([
                'message' => 'Wishtlist deleted!',
            ]);
        } else {

            $wishlist = Wishlist::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id
            ]);

            return response()->json([
                'message' => 'Wishtlist created!',
                'data' => $wishlist
            ]);
        }
    }
}
