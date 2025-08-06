<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\SamplingRequest;
use Auth;
use App\Models\VisitRequest;
use App\Models\GitDistributed;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_categories' => Category::latest()->take(5)->get(),
            'recent_products' => Product::latest()->take(5)->get()
        ];
            $employee = [
            'enquery' => 1 ,
            'enquery_today' => 1,
            'orders' => Order::where('user_id',Auth::user()->id)->count(),
            'orders_today' => Order::where('user_id', Auth::user()->id)->whereDate('created_at', today())->count(),
            'pending_payments' => Order::where('user_id',Auth::user()->id)->where('status',0)->count(),
            'pending_payment_today' => Order::where('user_id', Auth::user()->id)->where('status', 0)->whereDate('created_at', today())->count(),
            'sample_request' => SamplingRequest::where('user_id',Auth::user()->id)->count(),
            'sample_request_today'=>SamplingRequest::where('user_id', Auth::user()->id)->whereDate('created_at', today())->count(),
            'visit_request' => VisitRequest::where('user_id',Auth::user()->id)->count(),
            'visit_today' => VisitRequest::where('user_id', Auth::user()->id)->whereDate('created_at', today())->count(),
            'photo' => GitDistributed::where('user_id',Auth::user()->id)->count(),
            'photo_today'=>GitDistributed::where('user_id', Auth::user()->id)->whereDate('created_at', today())->count(),

        ];

        return view('admin.dashboard', compact('stats','employee'));
    }
}
