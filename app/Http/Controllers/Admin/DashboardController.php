<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

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

        return view('admin.dashboard', compact('stats'));
    }
}
