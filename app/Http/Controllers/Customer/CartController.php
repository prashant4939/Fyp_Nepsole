<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart');
        }
        
        $cartItems = Cart::with(['product.images', 'product.category', 'product.brand', 'variant'])
            ->where('user_id', Auth::id())
            ->get();
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('customer.cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to cart'
            ], 401);
        }

        $product = Product::findOrFail($request->product_id);
        $variant = \App\Models\ProductVariant::findOrFail($request->product_variant_id);

        // Check stock availability
        if ($variant->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Available: ' . $variant->stock
            ], 400);
        }

        // Check if item with same variant already exists in cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('product_variant_id', $request->product_variant_id)
            ->first();

        if ($cartItem) {
            // Check if new quantity exceeds stock
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity > $variant->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more. Stock limit: ' . $variant->stock
                ], 400);
            }
            
            // Update quantity
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'product_variant_id' => $request->product_variant_id,
                'quantity' => $request->quantity
            ]);
        }

        // Get updated cart count
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cartCount' => $cartCount
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        // Ensure user owns this cart item
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Ensure quantity is at least 1
        $quantity = max(1, $request->quantity);

        // Check stock availability if variant exists
        if ($cart->product_variant_id) {
            $variant = \App\Models\ProductVariant::find($cart->product_variant_id);
            if ($variant && $quantity > $variant->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $variant->stock
                ], 400);
            }
        }

        $cart->update(['quantity' => $quantity]);

        $subtotal = Cart::where('user_id', Auth::id())
            ->get()
            ->sum(function($item) {
                return $item->quantity * $item->product->price;
            });

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'subtotal' => $subtotal,
            'itemSubtotal' => $cart->quantity * $cart->product->price
        ]);
    }

    public function remove(Cart $cart)
    {
        // Ensure user owns this cart item
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $cart->delete();

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cartCount' => $cartCount
        ]);
    }

    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        
        return response()->json(['count' => $count]);
    }
}
