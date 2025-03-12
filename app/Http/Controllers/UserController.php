<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $products = Product::all();
        $categories = Category::all();
        $title = 'Stara - homepage';

        return view('user.index', compact("title", "products", "categories"));
    }

    public function login(){
        return view('auth.login', ['title' => 'Stara - Login']);
    }

    public function register(){
        return view('auth.register', ['title' => 'Stara - Register']);
    }


    public function products(Request $request): View
    {
        $products = Product::join("categories", "products.category_id", "categories.id")
        ->get();
        $categories = Category::all();

        
        if(!is_null($request->category)){
            $category = $request->category;
            $products = $products->where("category_name", "=",$category);
        }
        $title = 'Stara - Products';
        $currentCategory = $request->category;
        return view('user.product-list', compact('title', "products", "categories", "currentCategory"));
    }

    public function productDetails(string $productId): View
    {
        $product = Product::where("products.id", "=", $productId)
        ->first();
        $title = 'Stara - Product Details';
        return view('user.product-details', compact('title', 'product'));
    }

    public function cart(): View
    {
        $cartItems = CartItem::where('user_id', '=', Auth::id())
        ->join('products', 'cartitems.product_id', '=', 'products.id')
        ->get();
        $cartSubTotal = CartItem::where('user_id', '=', Auth::id())
        ->join('products', 'cartitems.product_id', '=', 'products.id')
        ->sum(DB::raw("price * quantity"));
        $title = 'Stara - Cart';
        return view('user.cart', compact('title', 'cartItems', 'cartSubTotal'));
    }

    public function checkout(): View
    {
        $orderItems = CartItem::where('user_id', '=', Auth::id())
        ->join('products', 'cartitems.product_id', '=', 'products.id')
        ->get();
        $title = 'Stara - Checkout';
        $orderSubtotal = CartItem::where('user_id', '=', Auth::id())
        ->join('products', 'cartitems.product_id', '=', 'products.id')
        ->sum(DB::raw("price * quantity"));
        return view('user.checkout', compact('orderItems', 'title', 'orderSubtotal'));
    }

    public function orderConfirmation(): View
    {
        return view('user.order-confirm', ['title' => 'Stara - Order Confirmation']);
    }

    public function massUpdateCart(Request $request): View
    {
        dd($request->all());
    }

    public function addToCart(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        $productId = intval($validatedData['product_id']);
        $quantity = intval($validatedData['quantity']);


        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => $quantity
        ]);

        return redirect()->back();
    }

    public function getCart(){
        $cartItems = CartItem::where('user_id', '=', Auth::id())->get();
        return response()->json($cartItems->values()->toArray());
    }

    public function getCartCount(){
        $cartItemCount = CartItem::where('user_id', '=', Auth::id())->count();
        return response()->json(['count' => $cartItemCount]);
    }

    public function updateCartItem(Request $request, $productId){
        $validatedData = $request->validate([
            'quantity' => 'required|integer'
        ]);

        $quantity = intval($validatedData['quantity']);

        $cartItem = CartItem::where('product_id', '=', $productId)->first();

        if(!$cartItem){
            return response()->json([], 404);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return response()->json([], 200);
    }

    public function removeCartItem($productId){
        $cartItem = CartItem::where('product_id', '=', $productId)->first();
        if(!$cartItem){
            return response()->json([], 404);
        }

        $cartItem->delete();
        return response()->json([], 200);
    }

    public function clearCart(){
        $cartItems = CartItem::where('user_id', '=', Auth::id())
                    ->delete();
                    
        return response()->json([], 200);
    }

    public function placeOrder(Request $request){
        $validatedData = $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string'
        ]);

        $cartItems = CartItem::where('user_id', '=', Auth::id());

        $shippingAddress = $validatedData['shipping_address'];
        $paymentMethod = $validatedData['payment_method'];
        $totalAmount = CartItem::where('user_id', '=', Auth::id())
                        ->join('products', 'cartitems.product_id', '=', 'products.id')
                        ->sum('products.price * cartitems.quantity');
        $trackingNumber = 0;


        $order = Order::create([
            "user_id" => Auth::id(),
            "order_status" => "pending",
            "shipping_address" => $shippingAddress,
            "billing_address" => Auth::user()->billing_address,
            "payment_method" => $paymentMethod,
            "total_amount" => $totalAmount,
            "shipping_cost" => 0,
            "discount_applied" => 0,
            "tracking_number" => $trackingNumber
        ]);

        foreach((clone $cartItems)->get() as $item){
            OrderItem::create([
                "order_id" => $order->id,
                "product_id" => $item->product_id,
                "quantity" => $item->quantity
            ]);
        }

        $cartItems->delete();
        return response()->json([], 200);
    }
}