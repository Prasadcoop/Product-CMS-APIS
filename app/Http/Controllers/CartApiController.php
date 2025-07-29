<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart_items;
use App\Models\orders;
use App\Models\orders_item;
use App\Services\RazorpayService;

class CartApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user_id = 1; // default to 1

            $cartItems = Cart_items::with('product')
                ->where('user_id', $user_id)
                ->get();


            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            return response()->json([
                'message' => 'Cart_items items fetched successfully.',
                'data' => $cartItems,
                'cart_total' => $total
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch cart items.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|min:1',
            ]);

            $user_id = 1;

            $cart = Cart_items::updateOrCreate(
                ['user_id' => $user_id, 'product_id' => $validated['product_id']],
                ['quantity' => DB::raw("quantity + {$validated['quantity']}")]
            );

            return response()->json([
                'message' => 'Product added to cart successfully.',
                'data' => $cart
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add product to cart.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem = Cart_items::findOrFail($id);
            $cartItem->update(['quantity' => $validated['quantity']]);

            return response()->json([
                'message' => 'Cart item updated successfully.',
                'data' => $cartItem
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update cart item.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $cartItem = Cart_items::findOrFail($id);

            // Instead of deleting, set quantity to 0
            $cartItem->quantity = 0;
            $cartItem->save();

            return response()->json([
                'message' => 'Cart item quantity set to 0 successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update cart item.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function checkout(Request $request, RazorpayService $razorpayService)
    {
        try {
            $userId = 1;

            $cartItems = Cart_items::where('user_id', $userId)->with('product')->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Cart is empty'], 400);
            }

            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->quantity * $item->product->price;
            }


            $razorpayOrder = $razorpayService->createOrder($total);

            DB::beginTransaction();
            $order = orders::create([
                'user_id' => $userId,
                'total_amount' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                orders_item::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
            }

            // Clear cart
            Cart_items::where('user_id', $userId)->delete();
            DB::commit();

            return response()->json([
                'message'         => 'Order created successfully',
                'razorpay_order'  => $razorpayOrder,
                'local_order_id'  => $order->id,
                'amount'          => $total,
                'currency'        => 'INR'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Checkout failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
