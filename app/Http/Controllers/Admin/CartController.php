<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart_items;
use App\Models\orders;
use App\Models\orders_item;
use App\Services\RazorpayService;
use DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Load cart items with related product details
        $cartItems = Cart_items::with('product')
            ->where('user_id', 1)
            ->get();

        return view('admin.cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        $userId = 1; 

        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $cartItem = Cart_items::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            Cart_items::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully.',
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = 1; // hardcoded user

        $cartItem = Cart_items::where('user_id', $userId)->where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['success' => true, 'message' => 'Cart item updated successfully.']);
    }
    public function destroy($id)
    {
        $userId = 1;

        $cartItem = Cart_items::where('user_id', $userId)->where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
        }

        $cartItem->delete();

        return response()->json(['success' => true, 'message' => 'Cart item deleted successfully.']);
    }


}
