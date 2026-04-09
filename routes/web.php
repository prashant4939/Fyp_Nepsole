<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\EmailVerificationController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VendorManagementController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\CategoryBrandController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\VendorRequestController;
use App\Http\Controllers\Admin\VendorRequestController as AdminVendorRequestController;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

// Become a Vendor (public)
Route::get('/become-a-vendor', [VendorRequestController::class, 'create'])->name('vendor-request.create');
Route::post('/become-a-vendor', [VendorRequestController::class, 'store'])->name('vendor-request.store');

// Public product routes
Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');
Route::get('/category/{category}', [CustomerProductController::class, 'byCategory'])->name('products.category');
Route::get('/brand/{brand}', [CustomerProductController::class, 'byBrand'])->name('products.brand');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
});

// Wishlist routes
Route::get('/wishlist', [\App\Http\Controllers\Customer\WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/count', [\App\Http\Controllers\Customer\WishlistController::class, 'count'])->name('wishlist.count');

Route::middleware('auth')->group(function () {
    Route::post('/wishlist/add', [\App\Http\Controllers\Customer\WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\Customer\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [\App\Http\Controllers\Customer\WishlistController::class, 'remove'])->name('wishlist.remove');
});

// Checkout and Order routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\Customer\CheckoutController::class, 'index'])->name('checkout.index');

    // Payment routes (COD + Khalti)
    Route::post('/checkout/place-order', [\App\Http\Controllers\Customer\PaymentController::class, 'placeOrder'])->name('checkout.place-order');
    Route::get('/khalti/callback', [\App\Http\Controllers\Customer\PaymentController::class, 'khaltiCallback'])->name('payment.khalti.callback');
    
    Route::get('/orders', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{orderId}/success', [\App\Http\Controllers\Customer\OrderController::class, 'success'])->name('orders.success');
    
    Route::post('/shipping-address', [\App\Http\Controllers\Customer\ShippingAddressController::class, 'store'])->name('shipping-address.store');
    Route::post('/shipping-address/{address}/set-default', [\App\Http\Controllers\Customer\ShippingAddressController::class, 'setDefault'])->name('shipping-address.set-default');
});

// Admin routes (separate from main site)
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/', [AdminAuthController::class, 'login'])->name('login.post');
    });
    
    // Protected admin routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        
        // Vendor Management Routes
        Route::get('/vendors', [VendorManagementController::class, 'index'])->name('vendors.index');
        Route::get('/vendors/{vendor}', [VendorManagementController::class, 'show'])->name('vendors.show');
        Route::post('/vendors/{vendor}/approve', [VendorManagementController::class, 'approve'])->name('vendors.approve');
        Route::delete('/vendors/{vendor}/reject', [VendorManagementController::class, 'reject'])->name('vendors.reject');
        Route::post('/vendors/{vendor}/deactivate', [VendorManagementController::class, 'deactivate'])->name('vendors.deactivate');
        Route::post('/vendors/{vendor}/reactivate', [VendorManagementController::class, 'reactivate'])->name('vendors.reactivate');
        
        // Brand Management Routes
        Route::resource('brands', BrandController::class);
        Route::post('/brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');
        
        // Category Management Routes
        Route::resource('categories', CategoryController::class);
        Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        
        // Order Management Routes
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/dispatch', [\App\Http\Controllers\Admin\OrderController::class, 'dispatch'])->name('orders.dispatch');
        
        // Customer Management Routes
        Route::get('/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
        Route::patch('/customers/{id}/toggle', [\App\Http\Controllers\Admin\CustomerController::class, 'toggle'])->name('customers.toggle');
        Route::delete('/customers/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customers.destroy');

        // Vendor Request Management Routes
        Route::get('/vendor-requests', [AdminVendorRequestController::class, 'index'])->name('vendor-requests.index');
        Route::get('/vendor-requests/{vendorRequest}', [AdminVendorRequestController::class, 'show'])->name('vendor-requests.show');
        Route::post('/vendor-requests/{vendorRequest}/approve', [AdminVendorRequestController::class, 'approve'])->name('vendor-requests.approve');
        Route::post('/vendor-requests/{vendorRequest}/reject', [AdminVendorRequestController::class, 'reject'])->name('vendor-requests.reject');
    });
});

// Guest routes (main site)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Vendor Routes
    Route::get('/vendor', [VendorController::class, 'showLogin'])->name('vendor.portal');
    Route::get('/vendor/login', [VendorController::class, 'showLogin'])->name('vendor.login');
    Route::post('/vendor/login', [VendorController::class, 'login'])->name('vendor.login.post');
    Route::get('/vendor/register', [VendorController::class, 'showRegistrationForm'])->name('vendor.register.form');
    Route::post('/vendor/register', [VendorController::class, 'register'])->name('vendor.register');
    Route::get('/vendor/pending', [VendorController::class, 'pending'])->name('vendor.pending');
    
    // Password Reset Routes
    Route::get('/forgot-password', [ProfileController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ProfileController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ProfileController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ProfileController::class, 'resetPassword'])->name('password.update');
});

// Authenticated routes (main site)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile routes (for all authenticated users)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Settings routes
    Route::get('/profile', [\App\Http\Controllers\SettingsController::class, 'profile'])->name('settings.profile');
    Route::get('/edit-profile', [\App\Http\Controllers\SettingsController::class, 'editProfile'])->name('settings.edit-profile');
    Route::put('/edit-profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.update-profile');
    Route::get('/change-password', [\App\Http\Controllers\SettingsController::class, 'changePassword'])->name('settings.change-password');
    Route::put('/change-password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.update-password');
    
    // Vendor routes
    Route::middleware('role:vendor')->prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/dashboard', [VendorDashboard::class, 'index'])->name('dashboard');
        
        // Browse Categories and Brands
        Route::get('/categories', [CategoryBrandController::class, 'categories'])->name('categories');
        Route::get('/brands', [CategoryBrandController::class, 'brands'])->name('brands');
        
        // Product Management Routes
        Route::resource('products', VendorProductController::class);
        
        // Image Management Routes
        Route::post('/products/{product}/images', [VendorProductController::class, 'storeImage'])->name('products.images.store');
        Route::delete('/products/{product}/images/{image}', [VendorProductController::class, 'deleteImage'])->name('products.images.delete');
        
        // Variant Management Routes
        Route::post('/products/{product}/images/{image}/variants', [VendorProductController::class, 'storeVariant'])->name('products.variants.store');
        Route::put('/products/{product}/variants/{variant}', [VendorProductController::class, 'updateVariant'])->name('products.variants.update');
        Route::delete('/products/{product}/variants/{variant}', [VendorProductController::class, 'deleteVariant'])->name('products.variants.delete');
        
        // Order Management Routes
        Route::get('/orders', [\App\Http\Controllers\Vendor\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Vendor\OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/items/{orderItem}/status', [\App\Http\Controllers\Vendor\OrderController::class, 'updateItemStatus'])->name('orders.update-item-status');
    });
    
    // Customer routes (accessible by customers and vendors)
    Route::middleware('role:customer,vendor')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
    });
});

