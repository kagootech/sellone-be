<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function charge(Request $request)
    {
        $data = $request->only([
            'product_id', 'cust_name', 'cust_address', 'qty'
        ]);

        $user = $request->user();
        $product = Product::find($data['product_id']);
        $seller = User::find($product->user_id);

        $gross_amount = $data['qty'] * $product->price;

        $order = Order::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'seller_id' => $seller->id,
            'customer_name' => $data['cust_name'],
            'customer_address' => $data['customer_address'],
            'qty' => $data['qty'],
            'status' => 1,
            'payment_method' => 'cod',
            'gross_amount' => $gross_amount
        ]);

        // If order created
        if($order){

            $invoice_url = env('APP_FE_URL') . '/order/' . $order->id;
            $redirect = 'https://wa.me/' . $seller->phone ?? 6289635796590 . '?text=' . $invoice_url . '+Halo' . $seller->name . '+Saya+konfirmasi+pesanan+saya+dong+bang/mba';

            return response()->json([
                'message' => 'Success! order created',
                'data' => [
                    'invoice_url' => $invoice_url,
                    'redirect_url' => $redirect
                ]
            ]);
        }

        // If order fail create
        return response()->json([
            'message' => 'Something error! order failed'
        ], 500);
    }
}
