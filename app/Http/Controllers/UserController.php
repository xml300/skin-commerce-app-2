<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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
        $title = 'Homepage';
 
        return view('user.index', compact("title", "products", "categories"))->with('message', 'Order not found');
    }

    public function search(Request $request)
    {
        $products = Product::whereLike('product_name', "%" . $request->q . "%")->get();
        return view('user.search', compact('products'));
    }

    public function about()
    {

    }

    public function privacy()
    {

    }

    public function terms()
    {

    }

    public function login()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    public function register()
    {
        return view('auth.register', ['title' => 'Register']);
    }


    public function products(Request $request): View
    {
        $products = Product::join("categories", "products.category_id", "categories.id")
            ->get();
        $categories = Category::all();


        if (!is_null($request->category)) {
            $category = $request->category;
            $products = $products->where("category_name", "=", $category);
        }
        $title = 'Products';
        $currentCategory = $request->category;
        return view('user.product-list', compact('title', "products", "categories", "currentCategory"));
    }

    public function productDetails(string $productId): View
    {
        $productId = Crypt::decrypt($productId);
        $product = Product::where("products.id", "=", $productId)
            ->first();
        $cartQuantity = CartItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->value('quantity');
        $title = 'Product Details';
        return view('user.product-details', compact('title', 'product', 'cartQuantity'));
    }

    public function cart(): View|RedirectResponse
    {
        $cartItems = CartItem::where('user_id', '=', Auth::id())
            ->join('products', 'cartitems.product_id', '=', 'products.id')
            ->get();



        $cartSubTotal = CartItem::where('user_id', '=', Auth::id())
            ->join('products', 'cartitems.product_id', '=', 'products.id')
            ->sum(DB::raw("price * quantity"));
        $title = 'Cart';
        return view('user.cart', compact('title', 'cartItems', 'cartSubTotal'));
    }

    public function checkout(): View
    {
        $orderItems = CartItem::where('user_id', '=', Auth::id())
            ->join('products', 'cartitems.product_id', '=', 'products.id')
            ->get();
        $title = 'Checkout';
        $orderSubtotal = CartItem::where('user_id', '=', Auth::id())
            ->join('products', 'cartitems.product_id', '=', 'products.id')
            ->sum(DB::raw("price * quantity"));
        return view('user.checkout', compact('orderItems', 'title', 'orderSubtotal'));
    }

    public function orderConfirmation(): View
    {
        return view('user.order-confirm', ['title' => 'Order Confirmation']);
    }


    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        $productId = intval($validatedData['product_id']);
        $quantity = intval($validatedData['quantity']);

        $cartItem = CartItem::where('user_id', '=', Auth::id())
            ->where('product_id', '=', $productId)
            ->first();

        if (is_null($cartItem)) {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        } else {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return redirect()->back();
    }

    public function getCart()
    {
        $cartItems = CartItem::where('user_id', '=', Auth::id())->get();
        return response()->json($cartItems->values()->toArray());
    }

    public function getCartCount()
    {
        $cartItemCount = CartItem::where('user_id', '=', Auth::id())->sum('quantity');
        return response()->json(['count' => $cartItemCount]);
    }

    public function updateCartItem(Request $request, $productId)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer'
        ]);

        $quantity = intval($validatedData['quantity']);

        $cartItem = CartItem::where('product_id', '=', $productId)->first();

        if (!$cartItem) {
            return response()->json([], 404);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return response()->json([], 200);
    }

    public function removeCartItem($productId)
    {
        $cartItem = CartItem::where('product_id', '=', $productId)->first();
        if (!$cartItem) {
            return response()->json([], 404);
        }

        $cartItem->delete();
        return response()->json([], 200);
    }

    public function clearCart()
    {
        $cartItems = CartItem::where('user_id', '=', Auth::id())
            ->delete();

        return response()->json([], 200);
    }

    public function orders(Request $request){
        $orders = Order::where('user_id', Auth::id());

        if($request->has('status') && $request->status != ''){
            $orders = $orders->where('order_status', '=', $request->status);
        }
        $orders = $orders->get();
        return view('user.orders', compact('orders'));
    }

    public function orderDetails($orderId){
        $order = Order::where('id', '=', Crypt::decrypt($orderId))
        ->where('user_id', '=', Auth::id())
        ->first();

        if($order == null){
            return redirect()->route('home');
        }

        return view('user.order-details', compact('order'));
    }

    public function placeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'shipping_method' => 'required|string',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string'
        ]);

        $cartItems = CartItem::where('user_id', '=', Auth::id());

        $shippingAddress = $validatedData['shipping_address'];
        $paymentMethod = $validatedData['payment_method'];
        $shippingMethod = $validatedData['shipping_method'];
        $shippingCost = 0;

        if ($shippingMethod == "express") {
            $shippingCost = 1000;
        }

        $totalAmount = CartItem::where('user_id', '=', Auth::id())
            ->join('products', 'cartitems.product_id', '=', 'products.id')
            ->sum(DB::raw('price * quantity')) + $shippingCost;
        $trackingNumber = 'ORD-' . Str::random(25);

        $order = Order::create([
            "user_id" => Auth::id(),
            "order_status" => "pending",
            "shipping_address" => $shippingAddress,
            "billing_address" => Auth::user()->billing_address,
            "payment_method" => $paymentMethod,
            "shipping_method" => $shippingMethod,
            "tax_amount" => 0,
            "total_amount" => $totalAmount,
            "shipping_cost" => $shippingCost,
            "discount_applied" => 0,
            "tracking_number" => $trackingNumber,
            "payment_status" => "pending"
        ]);

        foreach ((clone $cartItems)->get() as $item) {
            OrderItem::create([
                "order_id" => $order->id,
                "product_id" => $item->product_id,
                "quantity" => $item->quantity
            ]);
        }


        if ($paymentMethod == "paystack") {
            $url = "https://api.paystack.co/transaction/initialize";

            $fields = [
                'email' => Auth::user()->email,
                'amount' => $totalAmount * 100,
                'callback_url' => "http://localhost:8080/callback",
                'metadata' => ["cancel_action" => "http://localhost:8080/", "order_id" => Crypt::encrypt($order->id)]
            ];
            $headers = [
                "Authorization" => "Bearer sk_test_8da4254202f409573cf78bac2e9ea2d86a32adb4",
                "Cache-Control" => "no-cache",
            ];


            $result = Http::withHeaders($headers)
                ->post(
                    $url,
                    $fields
                );

            $body = json_decode($result->body());
            if ($body->status == true) {
                return redirect($body->data->authorization_url);
            }
        }
        return redirect()->to('/checkout')->with('message', 'Payment process failed');
    }

    public function orderSuccess(Request $request)
    {
        $orderId = $request->get('id');
        $cartItems = CartItem::where('user_id', '=', Auth::id());
        $cartItems->delete();

        $order = Order::where('user_id', '=', Auth::id())
            ->where('id', '=', Crypt::decrypt($orderId))
            ->where('order_status', '=', 'pending')
            ->first();

        if(is_null($order)){
            return redirect()->to('/')->with('message', 'Order not found');
        }
        
        $order->order_status = 'processing';
        $order->payment_status = 'paid';
        $order->save();


        return redirect()->to('/order-confirmation');

    }
    public function orderFailed(Request $request)
    {
        return redirect()->to('/checkout')->with('message', 'Payment process failed');
    }

    public function paymentCallback(Request $request)
    {
        $transRef = $request->get('trxref');
        $verify_url = "https://api.paystack.co/transaction/verify/" . $transRef;
        $headers = [
            "Authorization" => "Bearer sk_test_8da4254202f409573cf78bac2e9ea2d86a32adb4",
        ];
        $result = Http::withHeaders($headers)
            ->get($verify_url);

        $body = json_decode($result->body());
        $data = $body->data; 

        if ($data->status == "success" && $data->amount === $data->requested_amount) {
            return redirect()->to('/order-confirmation/success?id='.$data->metadata->order_id);
        }else{
            return redirect()->to('/order-confirmation/failed');
        }
    }
}