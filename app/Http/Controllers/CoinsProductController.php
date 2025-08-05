<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoinsProduct;
use App\Models\Category;
use App\Models\CoinsOders;

use Illuminate\Support\Facades\Auth;

class CoinsProductController extends Controller
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
    public function index(Request $request)
    {
        $query = CoinsProduct::with('category');

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
      
        return view('contractor.coins_products.index', compact('products', 'categories', 'contractor'));
    }

    /**
     * Display the specified product.
     */
    public function show(CoinsProduct $product)
    {
        $product->load('category','order');
        $contractor = Auth::guard('contractor')->user();

        // Get related products from the same category
        $relatedProducts = collect();
        if ($product->category) {
            $relatedProducts = CoinsProduct::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->get();
        }
   
        return view('contractor.coins_products.show', compact('product', 'contractor', 'relatedProducts'));
    }

     public function ProceedOrder(Request $request){
      
            CoinsOders::insert([
                'user_id'=>Auth::guard('contractor')->user()->id,
                 'order_number'=>$randomNumber = rand(100000, 999999),
                 'date' => date('Y-m-d'),
                'product_id'=>$request->product_id,
                'qty'=>$request->qty,
            ]);

        return redirect()->route('contractor.myorders')->with('success', 'Order placed successfully.');

    }

        public function OrderTrack($id){

        $order = CoinsOders::with('product')->findOrFail($id);

    return view('contractor.products.track_order', compact('order'));
    }

}
