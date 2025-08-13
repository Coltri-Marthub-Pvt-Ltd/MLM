<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CoinsProduct;
use Illuminate\Support\Facades\File;
use Auth;
use DB;
use App\Models\AcceptDeal;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::with('product')->latest()->orderBy('order_by','asc')->get();
        $products = CoinsProduct::all();
        return view('admin.deals.index', compact('deals','products'));
    }

    public function create()
    {
        $products = Product::active()->get();
        return view('admin.deals.create', compact('products'));
    }

 public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive,expired',
            'order_by' => 'required|integer'
        ]);

        $validated['description'] = $request->description;
         $validated['product_id'] = $request->product_id;
          $validated['coins'] = $request->coins;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('uploads/deals'), $imageName);
            $validated['image'] = 'uploads/deals/'.$imageName;
        }

        Deal::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Deal created successfully'
            ]);
        // return redirect()->route('admin.deals.index')->with('success', 'Deal created successfully!');
    }

public function acceptDeal(Request $request)
{
    $deal = Deal::find($request->id);

    if (!$deal) {
        return response()->json(['status' => 'error', 'message' => 'Deal not found.']);
    }
        AcceptDeal::updateOrInsert(
            [
                'user_id' => Auth::id(),
                'deal_id' => $deal->id
            ],
            [
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

    return response()->json(['status' => 'success', 'message' => 'Deal accepted successfully.']);
}

public function update(Request $request, Deal $deal)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'status' => 'required|in:active,inactive,expired',
        'order_by' => 'required|integer'
    ]);

    // Add optional fields
    $validated['description'] = $request->description;
    $validated['product_id'] = $request->product_id;
    $validated['coins'] = $request->coins;

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($deal->image && File::exists(public_path($deal->image))) {
            File::delete(public_path($deal->image));
        }

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('uploads/deals'), $imageName);
        $validated['image'] = 'uploads/deals/'.$imageName;
    }

    // Handle image removal
    if ($request->remove_image) {
        if ($deal->image && File::exists(public_path($deal->image))) {
            File::delete(public_path($deal->image));
        }
        $validated['image'] = null;
    }

    // ❌ Remove this line: Deal::create($validated);
    // ✅ Instead, update the existing deal
    $deal->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Deal updated successfully'
    ]);
}


    public function destroy(Deal $deal)
    {
        if ($deal->image && File::exists(public_path($deal->image))) {
            File::delete(public_path($deal->image));
        }

        $deal->delete();

        return redirect()->route('admin.deals.index')->with('success', 'Deal deleted successfully!');
    }

        public function edit(Deal $deal)
    {
        $products = Product::active()->get();
        return view('admin.deals.edit', compact('deal', 'products'));
    }

}
