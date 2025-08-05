<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoinsOders;
use App\Models\Contractor;

class CoinsOdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CoinsOders::with('contractor');

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('client', 'like', '%' . $request->search . '%')
                    ->orWhere('mkt_person', 'like', '%' . $request->search . '%')
                    ->orWhere('sales_person', 'like', '%' . $request->search . '%')
                    ->orWhere('partner_id', 'like', '%' . $request->search . '%')
                    ->orWhere('product', 'like', '%' . $request->search . '%');
            });
        }

        // Date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        // Area filter
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get unique areas for filter
        $areas = CoinsOders::distinct()->pluck('area')->filter()->sort()->values();

        return view('admin.coins_orders.index', compact('orders', 'areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coins_orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'mkt_person' => 'required|string|max:255',
            'sales_person' => 'required|string|max:255',
            'partner_id' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'rate' => 'required|numeric|min:0',
            'transport' => 'nullable|numeric|min:0',
            'supplier' => 'required|string|max:255',
            'partner_commission' => 'nullable|numeric|min:0'
        ]);

        CoinsOders::create($request->all());

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CoinsOders $order)
    {

        return view('admin.coins_orders.show', compact('order'));
    }

    public function orderStatus(Request $request)
    {
        $order = CoinsOders::find($request->id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $oldStatus = $order->status;

        $order->status = $request->status;

        if ($oldStatus != 2 && $request->status == 2) {
            $this->roiIncomes($request);
        }

        $order->save();

        return redirect()->back()->with('success', 'Order Status updated successfully.');
    }


    public function roiIncomes($request)
    {

        $currentLevel = Contractor::find($request->user_id);
        if ($currentLevel) {

            $currentLevel->increment('points', $request->points);

            $maxLevels = Contractor::count();
            $testing = [];
            for ($i = 0; $i <= $maxLevels; $i++) {
                if (!empty($currentLevel) && !empty($currentLevel->referenced_by)) {
                    
                    $nextLevel = Contractor::where('id', $currentLevel->referenced_by)->first();
                    $nextLevel->increment('points', ($currentLevel->points) / 2);
                    $nextLevel = $nextLevel->fresh();

                    if ($nextLevel) {
                        $testing[] = $currentLevel->points/2;
                        $currentLevel = $nextLevel;
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoinsOders $order)
    {
        return view('admin.coins_orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoinsOders $order)
    {
        $request->validate([
            'date' => 'required|date',
            'mkt_person' => 'required|string|max:255',
            'sales_person' => 'required|string|max:255',
            'partner_id' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'rate' => 'required|numeric|min:0',
            'transport' => 'nullable|numeric|min:0',
            'supplier' => 'required|string|max:255',
            'partner_commission' => 'nullable|numeric|min:0'
        ]);

        $order->update($request->all());

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoinsOders $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
