<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your wishlist');
        }
        
        $wishlistItems = Wishlist::with(['product.images', 'product.category', 'product.brand'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        return view('customer.wishlist.index', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to wishlist'
            ], 401);
        }

        // Check if item already exists in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist'
            ]);
        }

        // Create new wishlist item
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        // Get updated wishlist count
        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlistCount' => $wishlistCount
        ]);
    }

    public function remove(Wishlist $wishlist)
    {
        // Ensure user owns this wishlist item
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $wishlist->delete();

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist',
            'wishlistCount' => $wishlistCount
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to manage wishlist'
            ], 401);
        }

        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            $message = 'Removed from wishlist';
            $inWishlist = false;
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
            $message = 'Added to wishlist';
            $inWishlist = true;
        }

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'inWishlist' => $inWishlist,
            'wishlistCount' => $wishlistCount
        ]);
    }

    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Wishlist::where('user_id', Auth::id())->count();
        
        return response()->json(['count' => $count]);
    }
}
