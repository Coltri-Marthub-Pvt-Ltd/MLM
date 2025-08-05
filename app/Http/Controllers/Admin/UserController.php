<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $roleId = $request->role;
            $query->whereHas('roles', function($q) use ($roleId) {
                $q->where('roles.id', $roleId);
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'pending') {
                $query->whereNull('email_verified_at');
            }
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Get roles for filter dropdown
        $roles = \Spatie\Permission\Models\Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'nullable|exists:roles,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->filled('role')) {
            $role = Role::find($request->role);
            $user->assignRole($role->name);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('roles.permissions');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|exists:roles,id'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Handle role updates with protection for superadmin
        if ($user->id === 1) {
            // Superadmin must always have admin role
            if ($request->filled('role')) {
                $requestedRole = Role::find($request->role);
                if ($requestedRole->name !== 'admin') {
                    // If trying to assign non-admin role to superadmin, force admin role
                    $adminRole = Role::where('name', 'admin')->first();
                    $user->syncRoles($adminRole->name);
                } else {
                    $user->syncRoles($requestedRole->name);
                }
            } else {
                // If no role selected, ensure superadmin keeps admin role
                $adminRole = Role::where('name', 'admin')->first();
                $user->syncRoles($adminRole->name);
            }
        } else {
            // Regular role update for other users
            if ($request->filled('role')) {
                $role = Role::find($request->role);
                $user->syncRoles($role->name);
            } else {
                $user->syncRoles([]);
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deletion of superadmin (ID 1)
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Superadmin cannot be deleted. This user has the highest level of protection.');
        }
        
        // Prevent deletion of users with admin role
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Users with admin role cannot be deleted for security reasons.');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
