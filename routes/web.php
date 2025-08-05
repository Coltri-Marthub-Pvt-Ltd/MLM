<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ContractorLoginController;
use App\Http\Controllers\Auth\ContractorRegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CoinsOdersController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContractorController;
use App\Http\Controllers\Admin\CoinsProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\CoinsProductController as CoinContractorProductController;
use App\Http\Controllers\Contractor\DashboardController as ContractorDashboardController;
use App\Http\Controllers\Contractor\ProductController as ContractorProductController;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return '✅ All caches cleared successfully!';
});

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Contractor Authentication Routes
Route::get('/contractor/login', [ContractorLoginController::class, 'showLoginForm'])->name('contractor.login');
Route::post('/contractor/login', [ContractorLoginController::class, 'login']);
Route::post('/contractor/logout', [ContractorLoginController::class, 'logout'])->name('contractor.logout');

Route::get('/contractor/register', [ContractorRegisterController::class, 'showRegistrationForm'])->name('contractor.register');
Route::post('/contractor/register', [ContractorRegisterController::class, 'register']);

// Contractor Routes (Protected by contractor auth middleware)
Route::middleware(['auth:contractor'])->prefix('contractor')->name('contractor.')->group(function () {
    Route::get('/dashboard', [ContractorDashboardController::class, 'index'])->name('dashboard');
    
    // Product Routes for Contractors
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ContractorProductController::class, 'index'])->name('index');
        Route::get('/{product:slug}', [ContractorProductController::class, 'show'])->name('show');
        Route::post('/add-to-cart', [ContractorProductController::class, 'addToCart'])->name('cart');
        Route::post('/place-order', [ContractorProductController::class, 'placeOrder'])->name('myorder');

    });

        // Coins Product Routes for Contractors
    Route::prefix('coins-products')->name('coins-products.')->group(function () {
        Route::get('/', [CoinContractorProductController::class, 'index'])->name('index');
        Route::get('/{product:slug}', [CoinContractorProductController::class, 'show'])->name('show');
        Route::post('/proceed-to-order', [CoinContractorProductController::class, 'ProceedOrder'])->name('proceed');
        // Route::post('/place-order', [ContractorProductController::class, 'placeOrder'])->name('myorder');

    });
    
     Route::get('cart', [ContractorProductController::class, 'showcart'])->name('show.cart');
     Route::delete('contractor/cart-remove/{id}', [ContractorProductController::class, 'remoceCart'])->name('cart.remove');
     Route::post('contractor/update', [ContractorProductController::class, 'updateCart'])->name('cart.update');
     Route::get('proceed-to-checkout', [ContractorProductController::class, 'ProceedCheckout'])->name('cart.checkout');
     
     Route::get('my-orders', [ContractorProductController::class, 'myOrders'])->name('myorders');
     Route::get('orders/{id}/track', [ContractorProductController::class, 'OrderTrack'])->name('orders.track');
     Route::get('coins-orders/{id}/track', [CoinContractorProductController::class, 'OrderTrack'])->name('coins.orders.track');

});

// Admin Routes (Protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:view_dashboard')
        ->name('dashboard');
    
    Route::put('brands/{brand}', [BrandController::class, 'update'])->name('admin.brands.update');

    Route::resource('locations', LocationController::class);
    Route::resource('product-types', \App\Http\Controllers\Admin\ProductTypeController::class);
     Route::resource('badges', \App\Http\Controllers\Admin\BadgeController::class);
        Route::resource('gitcards', \App\Http\Controllers\Admin\GitCardController::class)->except(['show', 'create', 'edit']);
        Route::resource('limited-schemes', \App\Http\Controllers\Admin\LimitedSchemeController::class)->except(['show', 'create', 'edit']);
        Route::resource('deals', \App\Http\Controllers\Admin\DealController::class)->except(['show', 'create', 'edit']);
        Route::resource('new-schemes', \App\Http\Controllers\Admin\NewSchemeController::class)->except(['show', 'create', 'edit']);
        Route::resource('new-opportunities', \App\Http\Controllers\Admin\NewOpportunityController::class);
          Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    
    // Additional route for deleting gallery images
     Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::delete('events/{event}/images/{mediaId}', [\App\Http\Controllers\Admin\EventController::class, 'deleteImage'])
        ->name('admin.events.deleteImage');

        Route::resource('sampling-requests', \App\Http\Controllers\Admin\SamplingRequestController::class)->except(['show']);
    Route::get('sampling-requests/{samplingRequest}', [\App\Http\Controllers\Admin\SamplingRequestController::class, 'show'])->name('sampling-requests.show');


        Route::resource('brands', BrandController::class);
    // User Management Routes
    Route::prefix('users')->name('users.')->group(function () {
        // Manage permissions (create routes first)
        Route::middleware('permission:manage_users')->group(function () {
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });
        
        // View permissions (parameterized routes last)
        Route::middleware('permission:view_users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
        });
    });
    
    // Role Management Routes
    Route::prefix('roles')->name('roles.')->group(function () {
        // Manage permissions (create routes first)
        Route::middleware('permission:manage_roles')->group(function () {
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        });
        
        // View permissions (parameterized routes last)
        Route::middleware('permission:view_roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        });
    });
    
    // Permission Management Routes
    Route::prefix('permissions')->name('permissions.')->group(function () {
        // Manage permissions (create routes first)
        Route::middleware('permission:manage_permissions')->group(function () {
            Route::get('/create', [PermissionController::class, 'create'])->name('create');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
        });
        
        // View permissions (parameterized routes last)
        Route::middleware('permission:view_permissions')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');
        });
    });
    
    // Category Management Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        // Manage permissions (create routes first)
        Route::middleware('permission:manage_categories')->group(function () {
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
            
        });
        
        // View permissions (parameterized routes last)
        Route::middleware('permission:view_categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        });
    });
    
    // Product Management Routes
    Route::prefix('coins-products')->name('coins-products.')->group(function () {
        // Manage permissions (create routes first)
        Route::middleware('permission:manage_products')->group(function () {
            Route::get('/create', [CoinsProductController::class, 'create'])->name('create');
            Route::post('/store', [CoinsProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [CoinsProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [CoinsProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [CoinsProductController::class, 'destroy'])->name('destroy');
            Route::delete('/{product}/remove-image', [CoinsProductController::class, 'removeImage'])->name('remove-image');
        });
        
        // View permissions (parameterized routes last)
        Route::middleware('permission:view_products')->group(function () {
            Route::get('/', [CoinsProductController::class, 'index'])->name('index');
            Route::get('/{product}', [CoinsProductController::class, 'show'])->name('show');
        });
    });


        // Coins Product Management Routes
    Route::prefix('products')->name('products.')->group(function () {
        // Manage permissions (create routes first)
        Route::middleware('permission:manage_products')->group(function () {
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
            Route::delete('/{product}/remove-image', [ProductController::class, 'removeImage'])->name('remove-image');
        });
        
        // View permissions (parameterized routes last)
        Route::middleware('permission:view_products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        });
    });

    
    // Order Management Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        // Manage permissions (create routes first)
        Route::middleware('permission:manage_orders')->group(function () {
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('/{order}', [OrderController::class, 'update'])->name('update');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
            Route::post('/order-status-update', [OrderController::class, 'orderStatus'])->name('status.update');
        });
        
        // View permissions (parameterized routes last)
        Route::middleware('permission:view_orders')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        });
    });
    
    // coin order controller
        // Order Management Routes
    Route::prefix('coins-orders')->name('coins-orders.')->group(function () {
        // Manage permissions (create routes first)
        Route::middleware('permission:manage_orders')->group(function () {
            Route::get('/create', [CoinsOdersController::class, 'create'])->name('create');
            Route::post('/', [CoinsOdersController::class, 'store'])->name('store');
            Route::get('/{order}/edit', [CoinsOdersController::class, 'edit'])->name('edit');
            Route::put('/{order}', [CoinsOdersController::class, 'update'])->name('update');
            Route::delete('/{order}', [CoinsOdersController::class, 'destroy'])->name('destroy');
            Route::post('/order-status-update', [CoinsOdersController::class, 'orderStatus'])->name('status.update');
        });
        
        // View permissions (parameterized routes last)
        Route::middleware('permission:view_orders')->group(function () {
            Route::get('/', [CoinsOdersController::class, 'index'])->name('index');
            Route::get('/{order}', [CoinsOdersController::class, 'show'])->name('show');
        });
    });

    
    // Task Management Routes
    Route::prefix('tasks')->name('tasks.')->group(function () {
        // Manage permissions (create routes first) - Admin only
        Route::middleware('permission:manage_tasks')->group(function () {
            Route::get('/create', [TaskController::class, 'create'])->name('create');
            Route::post('/', [TaskController::class, 'store'])->name('store');
            Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
            Route::put('/{task}', [TaskController::class, 'update'])->name('update');
            Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        });
        
        // View permissions - All users with view_tasks permission
        Route::middleware('permission:view_tasks')->group(function () {
            Route::get('/', [TaskController::class, 'index'])->name('index');
            Route::get('/{task}', [TaskController::class, 'show'])->name('show');
            Route::post('/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('toggle-status');
        });
    });
    
    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::middleware('permission:manage_settings')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::put('/', [SettingController::class, 'update'])->name('update');
            Route::post('/reset', [SettingController::class, 'reset'])->name('reset');
        });
    });

    // Contractor Management Routes
    Route::prefix('contractors')->name('contractors.')->group(function () {
        Route::middleware('permission:manage_contractors')->group(function () {
            Route::get('/create', [ContractorController::class, 'create'])->name('create');
            Route::post('/', [ContractorController::class, 'store'])->name('store');
            Route::get('/', [ContractorController::class, 'index'])->name('index');
            Route::get('/{contractor}', [ContractorController::class, 'show'])->name('show');
            Route::get('/{contractor}/edit', [ContractorController::class, 'edit'])->name('edit');
            Route::put('/{contractor}', [ContractorController::class, 'update'])->name('update');
            Route::delete('/{contractor}', [ContractorController::class, 'destroy'])->name('destroy');
            Route::post('/{contractor}/verify', [ContractorController::class, 'verify'])->name('verify');
            Route::post('/{contractor}/toggle-status', [ContractorController::class, 'toggleStatus'])->name('toggle-status');
        });
    });
});
