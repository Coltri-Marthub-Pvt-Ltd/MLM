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
use App\Models\ProductType;
use App\Models\Brand;
use App\Models\Location;

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
    public function categories($any){
        if($any=='category'){
            $data = Category::with('products')->get();
        }elseif($any=='type'){
            $data =ProductType::with('products')->get();
        }
        elseif($any=='brand'){
            $data =Brand::with('products')->get();
        }
        elseif($any=='area'){
            $data =Location::with('products')->get();
        }
         return view('contractor.products.caregories', compact('data'));
    }

        public function TypeBrand(){
        $data =Brand::with('products')->get();
         return view('contractor.products.type_brand', compact('data'));
    }

    public function brandProduct(Request $request, $brand,$id){
        $filters = [
            'brands' => 'brand_id',
            'categories' => 'category_id',
            'locations' => 'location_id',
            'product_types' => 'product_type_id',
            // add more as needed
        ];

       if (isset($filters[$brand])) {
            $query = Product::where($filters[$brand], $id);

        }else{
             $query = Product::all();
        }

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
    public function wise(){
        $category = Category::get()->count();
         $brand = Brand::get()->count();
          $appliChart = ProductType::get()->count();
           $area = Location::get()->count();

         return view('contractor.products.tab', compact('category','brand','appliChart','area'));
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

        public function checkOrder(Request $request)
        {
            try {
                $existingOrder = Order::where('user_id', Auth::guard('contractor')->user()->id)
                    ->where('product_id', $request->product_id)
                    ->where('status','!=', 3)
                    ->latest()
                    ->first();

                return response()->json([
                    'exists' => $existingOrder ? true : false,
                    'status' => $existingOrder ? $existingOrder->status : null,
                    'message' => $existingOrder ? 'An order for this product is already in process' : 'No conflicting order found'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => 'Error checking order status: ' . $e->getMessage()
                ], 500);
            }
        }

    public function ProceedToOrder(Request $request)
    {

        try {
            $product = Product::findOrFail($request->product_id);
            $order = Order::create([
                'user_id' => Auth::guard('contractor')->user()->id,
                'order_number' => rand(100000, 999999),
                'date' => now()->format('Y-m-d'),
                'product_id' => $product->id,
                'qty' => $request->qty,
                'rate' => $product->price,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order: ' . $e->getMessage()
            ], 500);
        }
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
