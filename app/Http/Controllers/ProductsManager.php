<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class ProductsManager extends Controller
{
    //Show all products
    function index()
    {
        $products = Products::paginate(2);
        return view('products', compact('products'));
    }

    //Show product details
    function details($slug)
    {
        $product = Products::where('slug', $slug)->first();
        return view('details', compact('product'));
    }

    //Add product to cart
    function addToCart($id, $quantity = 1)
    {
        try {
            // Check if product already exists in user's cart
            $existingCartItem = Cart::where('user_id', auth()->user()->id)
                ->where('product_id', $id)
                ->first();

            if ($existingCartItem) {
                // Product already in cart, increment quantity
                $existingCartItem->quantity += $quantity;
                $existingCartItem->save();
                return redirect()->back()->with('success', 'Product quantity updated in cart');
            } else {
                // Product not in cart, create new cart item
                Cart::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $id,
                    'quantity' => $quantity
                ]);
                return redirect()->back()->with('success', 'Product added to cart');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to add product to cart');
        }
    }

    //Show cart
    function showCart()
    {
        $cartItems = DB::table('cart')
            ->join(
                'products',
                'cart.product_id',
                '=',
                'products.id'
            )
            ->select(
                'cart.product_id',
                'cart.quantity',
                'products.title',
                'products.price',
                'products.image',
                'products.slug',
            )
            ->where('cart.user_id', auth()->user()->id)
            ->groupBy(
                'cart.product_id',
                'cart.quantity',
                'products.title',
                'products.price',
                'products.image',
                'products.slug',
            )
            ->paginate(5);

        return view('cart', compact('cartItems'));
    }
}
