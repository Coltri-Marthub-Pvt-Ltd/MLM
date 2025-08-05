<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Order;
use App\Models\CoinsOders;
class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:contractor');
    }

    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->inCategory($request->category);
        }



        // Sort functionality
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        switch ($sort) {
            case 'price':
                $query->orderBy('price', $direction);
                break;
            case 'points':
                $query->orderBy('points', $direction);
                break;
            case 'created_at':
                $query->orderBy('created_at', $direction);
                break;
            default:
                $query->orderBy('name', $direction);
        }

        $products = $query->paginate(12)->appends($request->query());
        $categories = Category::orderBy('name')->get();

        $contractor = Auth::guard('contractor')->user();
        
        return view('contractor.products.index', compact('products', 'categories', 'contractor'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load('category','cart');
        $contractor = Auth::guard('contractor')->user();

        // Get related products from the same category
        $relatedProducts = collect();
        if ($product->category) {
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->get();
        }
     
        return view('contractor.products.show', compact('product', 'contractor', 'relatedProducts'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $qty = $request->input('qty');
        $product = Product::find($productId);

        Cart::insert([
            'user_id'=> Auth::guard('contractor')->user()->id,
            'product_id'=>$productId,
            'qty'=>$qty,
            'price'=>$product->price*$qty,
            'points'=>$product->points*$qty,
        ]);
        
        $cart = session()->get('cart', []);
        $cart[$productId] = $qty;

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Added to cart']);
    }

    public function placeOrder(Request $request)
    {
        $productId = $request->input('product_id');
        $qty = $request->input('qty');

        // Save to orders table or any order logic you want
        // For demo purposes:
        Session::push('orders', ['product_id' => $productId, 'qty' => $qty]);

        return response()->json(['success' => true, 'message' => 'Order placed']);
    }
    public function showcart(){
        $carts =Cart::with('product')->where('user_id',Auth::guard('contractor')->user()->id)->get();
       
       return view('contractor.products.cart', compact('carts'));
    }
       public function remoceCart($id){
        Cart::find($id)->delete();
       return redirect()->back()->with('success', 'Item removed from cart successfully.');
    }

      public function updateCart(Request $request){

            $productId = $request->input('product_id');
            $qty = $request->input('qty');
            $id = $request->input('id');
            $product = Product::find($productId);

            Cart::find($id)->update([
                'qty'=>$qty,
                'price'=>$product->price*$qty,
                'points'=>$product->points*$qty,
            ]);
        
        $cart = session()->get('cart', []);
        $cart[$productId] = $qty;

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Cart Updated Successfully']);
        
    }
    public function ProceedCheckout(){
      
        $carts = Cart::with('product')->where('user_id',Auth::guard('contractor')->user()->id)->get();
        foreach($carts as $cart){
            Order::insert([
                'user_id'=>Auth::guard('contractor')->user()->id,
                 'order_number'=>$randomNumber = rand(100000, 999999),
                 'date' => date('Y-m-d'),
                'product_id'=>$cart->product->id,
                'qty'=>$cart->qty,
                'rate'=>$cart->product->price,
            ]);
        }
         Cart::where('user_id', Auth::guard('contractor')->user()->id)->delete();

        return redirect()->route('contractor.myorders')->with('success', 'Order placed successfully.');

    }

    public function myOrders(){
        $orders = Order::with('product')
        ->where('user_id',Auth::guard('contractor')->user()->id)
        ->paginate(10);
         $coinsOrders = CoinsOders::with('product')
        ->where('user_id',Auth::guard('contractor')->user()->id)
        ->paginate(10);
       
         return view('contractor.products.myorder', compact('orders','coinsOrders'));
    }

    public function OrderTrack($id){

        $order = Order::with('product')->findOrFail($id);

    return view('contractor.products.track_order', compact('order'));
    }
}
