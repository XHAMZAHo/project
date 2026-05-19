<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\ClientProjectController;
use App\Http\Controllers\Client\ClientInvoiceController;
use App\Http\Controllers\Client\ClientMessageController;
use App\Http\Controllers\Client\ClientFileController;
use App\Http\Controllers\Client\ClientProfileController;
use App\Http\Middleware\ClientMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Language Switcher
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['ar', 'en'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services',  [PageController::class, 'services'])->name('services');
Route::get('/services/{service}', [PageController::class, 'serviceDetail'])->name('services.detail');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/about',     [PageController::class, 'about'])->name('about');
Route::get('/contact',   [PageController::class, 'contact'])->name('contact');
Route::post('/contact',  [ContactController::class, 'store'])->name('contact.store');
Route::get('/faq',       [PageController::class, 'faq'])->name('faq');
Route::get('/blog',      [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{post}', [PageController::class, 'blogPost'])->name('blog.post');

/*
|--------------------------------------------------------------------------
| Cart & Order Routes
|--------------------------------------------------------------------------
*/
Route::get('/cart',               [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add',          [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{key}',      [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear',        [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count',         [CartController::class, 'count'])->name('cart.count');
Route::get('/checkout',           [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout',          [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success',      [OrderController::class, 'success'])->name('order.success');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Analytics
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');

    // Leads (service requests)
    Route::get('/leads',              [\App\Http\Controllers\Admin\LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/{lead}',       [\App\Http\Controllers\Admin\LeadController::class, 'show'])->name('leads.show');
    Route::patch('/leads/{lead}',     [\App\Http\Controllers\Admin\LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/{lead}',    [\App\Http\Controllers\Admin\LeadController::class, 'destroy'])->name('leads.destroy');

    // Projects (Kanban) — explicit routes to avoid conflict with create
    Route::get('/projects',                   [\App\Http\Controllers\Admin\ProjectAdminController::class, 'index'])->name('projects.index');
    Route::get('/projects/create',            [\App\Http\Controllers\Admin\ProjectAdminController::class, 'create'])->name('projects.create');
    Route::post('/projects',                  [\App\Http\Controllers\Admin\ProjectAdminController::class, 'store'])->name('projects.store');
    Route::post('/projects/{project}/status', [\App\Http\Controllers\Admin\ProjectAdminController::class, 'updateStatus'])->name('projects.status');
    Route::delete('/projects/{project}',      [\App\Http\Controllers\Admin\ProjectAdminController::class, 'destroy'])->name('projects.destroy');

    // Clients CRM
    Route::get('/clients',          [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'show'])->name('clients.show');

    // Invoices
    Route::get('/invoices',                      [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create',               [\App\Http\Controllers\Admin\InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices',                     [\App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}',            [\App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('invoices.show');
    Route::patch('/invoices/{invoice}/status',   [\App\Http\Controllers\Admin\InvoiceController::class, 'updateStatus'])->name('invoices.update-status');
    Route::get('/invoices/{invoice}/pdf',        [\App\Http\Controllers\Admin\InvoiceController::class, 'pdf'])->name('invoices.pdf');
    Route::delete('/invoices/{invoice}',         [\App\Http\Controllers\Admin\InvoiceController::class, 'destroy'])->name('invoices.destroy');

    // Messages
    Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'store'])->name('messages.store');

    // Testimonials (existing)
    Route::resource('testimonials', TestimonialController::class);

    // Contacts (existing)
    Route::get('contacts',              [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}',    [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Legacy
    Route::get('service-requests', [ServiceRequestController::class, 'index'])->name('service-requests.index');

    // Services Management
    Route::get('/services',                       [\App\Http\Controllers\Admin\ServiceAdminController::class, 'index'])->name('services.index');
    Route::get('/services/create',                [\App\Http\Controllers\Admin\ServiceAdminController::class, 'create'])->name('services.create');
    Route::post('/services',                      [\App\Http\Controllers\Admin\ServiceAdminController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit',        [\App\Http\Controllers\Admin\ServiceAdminController::class, 'edit'])->name('services.edit');
    Route::patch('/services/{service}',           [\App\Http\Controllers\Admin\ServiceAdminController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}',          [\App\Http\Controllers\Admin\ServiceAdminController::class, 'destroy'])->name('services.destroy');
    Route::post('/services/{service}/toggle',     [\App\Http\Controllers\Admin\ServiceAdminController::class, 'toggleActive'])->name('services.toggle');

    // Orders Management
    Route::get('/orders',                         [\App\Http\Controllers\Admin\OrderAdminController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}',                 [\App\Http\Controllers\Admin\OrderAdminController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status',        [\App\Http\Controllers\Admin\OrderAdminController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}',              [\App\Http\Controllers\Admin\OrderAdminController::class, 'destroy'])->name('orders.destroy');

    // FAQs Management
    Route::get('/faqs',                           [\App\Http\Controllers\Admin\FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create',                    [\App\Http\Controllers\Admin\FaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs',                          [\App\Http\Controllers\Admin\FaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{faq}/edit',                [\App\Http\Controllers\Admin\FaqController::class, 'edit'])->name('faqs.edit');
    Route::patch('/faqs/{faq}',                   [\App\Http\Controllers\Admin\FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}',                  [\App\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('faqs.destroy');

    // Settings
    Route::get('/settings',                       [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings',                     [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';

// Append Client Portal Routes
Route::middleware(['auth', ClientMiddleware::class])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

    // Projects
    Route::get('/projects', [ClientProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ClientProjectController::class, 'show'])->name('projects.show');

    // Invoices
    Route::get('/invoices', [ClientInvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [ClientInvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/download', [ClientInvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/invoices/{invoice}/pay', [ClientInvoiceController::class, 'pay'])->name('invoices.pay');

    // Messages
    Route::get('/messages', [ClientMessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [ClientMessageController::class, 'store'])->name('messages.store');

    // Files
    Route::get('/files', [ClientFileController::class, 'index'])->name('files.index');
    Route::post('/projects/{project}/files', [ClientFileController::class, 'upload'])->name('files.upload');
    Route::delete('/files/{file}', [ClientFileController::class, 'destroy'])->name('files.destroy');

    // Services Ordering
    Route::get('/services/{service}/order', [\App\Http\Controllers\Client\ClientServiceController::class, 'order'])->name('services.order');

    // Profile
    Route::get('/profile', [ClientProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ClientProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ClientProfileController::class, 'updatePassword'])->name('profile.password');
});

// File download (signed route for security)
Route::get('/download-file/{file}', [ClientFileController::class, 'download'])
    ->name('file.download')
    ->middleware(['auth', 'signed']);

// Public Payment routes (Stripe)
Route::post('/invoice/{invoice}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

// Stripe Webhook
Route::post('/stripe/webhook', [WebhookController::class, 'handle'])->name('cashier.webhook');

// Update Auth routes to redirect based on role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin() || auth()->user()->isStaff()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('client.dashboard');
})->middleware(['auth'])->name('dashboard');
