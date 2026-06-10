<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScooterController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DealershipController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\GalleryAdminController;
use App\Http\Controllers\Admin\ScooterAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\Admin\SettingsController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::post('/emi-calculate', [HomeController::class, 'calculateEMI'])->name('emi.calculate');

// Scooters
Route::get('/scooters', [ScooterController::class, 'index'])->name('scooters.index');
Route::get('/scooters/{scooter:slug}', [ScooterController::class, 'show'])->name('scooters.show');
Route::post('/scooters/compare', [ScooterController::class, 'compare'])->name('scooters.compare');
Route::post('/test-ride', [ScooterController::class, 'bookTestRide'])->name('test-ride.book');

// Spare Parts
Route::get('/spare-parts', [SparePartController::class, 'index'])->name('parts.index');
Route::get('/spare-parts/{part:slug}', [SparePartController::class, 'show'])->name('parts.show');

// Cart
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [OrderController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart', [OrderController::class, 'cart'])->name('cart.index');
Route::get('/cart/json', [OrderController::class, 'cartJson'])->name('cart.json');
Route::post('/cart/clear', [OrderController::class, 'clearCart'])->name('cart.clear');

// Orders
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/order/cod', [OrderController::class, 'placeCOD'])->name('order.cod');
Route::post('/order/razorpay/create', [OrderController::class, 'createRazorpayOrder'])->name('order.razorpay.create');
Route::post('/order/razorpay/verify', [OrderController::class, 'verifyRazorpay'])->name('order.razorpay.verify');
Route::get('/order/{orderNo}/success', [OrderController::class, 'orderSuccess'])->name('order.success');
Route::get('/order/{orderNo}/track', [OrderController::class, 'trackOrder'])->name('order.track');

// Other pages
Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
Route::post('/service/book', [ServiceController::class, 'book'])->name('service.book');
Route::get('/dealership', [DealershipController::class, 'index'])->name('dealership.index');
Route::post('/dealership/apply', [DealershipController::class, 'apply'])->name('dealership.apply');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Admin Login
Route::get('/admin/login', [DashboardController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [DashboardController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [DashboardController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [OrderAdminController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderAdminController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('orders.status');
    Route::delete('/orders/{order}', [OrderAdminController::class, 'destroy'])->name('orders.destroy');
    Route::resource('/inventory', InventoryController::class);
    Route::post('/inventory/{inventory}/stock', [InventoryController::class, 'updateStock'])->name('inventory.stock');
    Route::resource('/scooters', ScooterAdminController::class);
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::get('/test-rides', [BookingController::class, 'testRides'])->name('test-rides.index');
    Route::patch('/test-rides/{booking}/status', [BookingController::class, 'updateTestRideStatus'])->name('test-rides.status');
    Route::get('/dealers', [BookingController::class, 'dealers'])->name('dealers.index');
    Route::get('/dealers/{application}', [BookingController::class, 'dealerShow'])->name('dealers.show');
    Route::patch('/dealers/{application}/status', [BookingController::class, 'dealerStatus'])->name('dealers.status');
    Route::resource('/blog', BlogAdminController::class);
    Route::resource('/gallery', GalleryAdminController::class);
    Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/approve', [ReviewAdminController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{review}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/messages', [DashboardController::class, 'messages'])->name('messages.index');
    Route::patch('/messages/{message}/read', [DashboardController::class, 'markRead'])->name('messages.read');
    Route::delete('/messages/{message}', [DashboardController::class, 'destroyMessage'])->name('messages.destroy');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
// Shiprocket Webhook
Route::post('/shiprocket/webhook', [App\Http\Controllers\ShiprocketWebhookController::class, 'handle'])->name('shiprocket.webhook')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Admin Shiprocket Actions
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::post('/orders/{order}/ship', [App\Http\Controllers\Admin\OrderAdminController::class, 'createShipment'])->name('orders.ship');
    Route::post('/orders/{order}/cancel-shipment', [App\Http\Controllers\Admin\OrderAdminController::class, 'cancelShipment'])->name('orders.cancel-shipment');
    Route::get('/orders/{order}/track', [App\Http\Controllers\Admin\OrderAdminController::class, 'trackShipment'])->name('orders.track');
});

// Scooter Image Management
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::delete('/scooters/image/{image}/delete', [App\Http\Controllers\Admin\ScooterAdminController::class, 'deleteImage'])->name('scooters.image.delete');
    Route::post('/scooters/image/{image}/primary', [App\Http\Controllers\Admin\ScooterAdminController::class, 'setPrimary'])->name('scooters.image.primary');
});
