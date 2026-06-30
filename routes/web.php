<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/admin', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout']);

use App\Http\Controllers\Admin\CompanySettingController;
use App\Http\Controllers\Admin\SmtpSettingController;
use App\Http\Controllers\Admin\PageSettingController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('can:manage_dashboard');
    
    // Quotations (Interactive / Mockup)
    Route::get('/admin/quotations/create', [\App\Http\Controllers\Admin\QuotationController::class, 'create'])->name('admin.quotations.create');
    
    // Settings
    Route::middleware('can:manage_settings')->group(function () {
        Route::get('/admin/settings/company', [CompanySettingController::class, 'index']);
        Route::post('/admin/settings/company', [CompanySettingController::class, 'update']);
        Route::get('/admin/settings/policies', [CompanySettingController::class, 'editPolicies']);
        Route::post('/admin/settings/policies', [CompanySettingController::class, 'updatePolicies']);
        Route::get('/admin/settings/smtp', [SmtpSettingController::class, 'index']);
        Route::post('/admin/settings/smtp', [SmtpSettingController::class, 'update']);
        Route::get('/admin/settings/hero', [\App\Http\Controllers\Admin\HeroSettingController::class, 'index']);
        Route::post('/admin/settings/hero', [\App\Http\Controllers\Admin\HeroSettingController::class, 'update']);
        
        // Page Settings
        Route::get('/admin/settings/pages/home', [PageSettingController::class, 'home'])->name('admin.settings.pages.home');
        Route::post('/admin/settings/pages/home/header', [PageSettingController::class, 'updateHomeHeader'])->name('admin.settings.pages.home.header');
        Route::post('/admin/settings/pages/home/about', [PageSettingController::class, 'updateAbout'])->name('admin.settings.pages.home.about.update');
        Route::post('/admin/settings/pages/home/service', [PageSettingController::class, 'storeService'])->name('admin.settings.pages.home.service.store');
        Route::post('/admin/settings/pages/home/service/{id}', [PageSettingController::class, 'updateService'])->name('admin.settings.pages.home.service.update');
        Route::delete('/admin/settings/pages/home/service/{id}', [PageSettingController::class, 'destroyService'])->name('admin.settings.pages.home.service.destroy');
        Route::post('/admin/settings/pages/home/service/reorder', [PageSettingController::class, 'reorderServices'])->name('admin.settings.pages.home.service.reorder');
        Route::resource('/admin/settings/slider', \App\Http\Controllers\Admin\WebsiteController::class)->except(['show']);
        Route::get('/admin/settings/testimonial', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialIndex']);
        Route::get('/admin/settings/testimonial/create', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialCreate']);
        Route::post('/admin/settings/testimonial', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialStore']);
        Route::get('/admin/settings/testimonial/{testimonial}/edit', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialEdit']);
        Route::put('/admin/settings/testimonial/{testimonial}', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialUpdate']);
        Route::delete('/admin/settings/testimonial/{testimonial}', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialDestroy']);
    });

    // Blogs
    Route::middleware('can:manage_blogs')->group(function () {
        Route::resource('/admin/blogs', \App\Http\Controllers\Admin\BlogController::class)->except(['show']);
        Route::delete('/admin/blogs/image/{id}', [\App\Http\Controllers\Admin\BlogController::class, 'deleteImage']);
    });

    // FAQs
    Route::resource('/admin/faqs', \App\Http\Controllers\Admin\FaqController::class)->except(['show'])->middleware('can:manage_faqs');

    // Tours
    Route::middleware('can:manage_tours')->group(function () {
        Route::get('/admin/tours/{tour}/seo', [\App\Http\Controllers\Admin\TourController::class, 'editSeo'])->name('tours.seo.edit');
        Route::put('/admin/tours/{tour}/seo', [\App\Http\Controllers\Admin\TourController::class, 'updateSeo'])->name('tours.seo.update');
        Route::resource('/admin/tours', \App\Http\Controllers\Admin\TourController::class)->except(['show']);
        Route::delete('/admin/tours/image/{id}', [\App\Http\Controllers\Admin\TourController::class, 'deleteImage']);
        Route::patch('/admin/tours/{tour}/toggle-status', [\App\Http\Controllers\Admin\TourController::class, 'toggleStatus'])->name('tours.toggle-status');
    });

    // Additional Inclusions
    Route::middleware('can:manage_inclusions')->group(function () {
        Route::get('/admin/additional-inclusions', [\App\Http\Controllers\Admin\TourController::class, 'inclusionIndex'])->name('additional-inclusions.index');
        Route::get('/admin/additional-inclusions/create', [\App\Http\Controllers\Admin\TourController::class, 'inclusionCreate'])->name('additional-inclusions.create');
        Route::post('/admin/additional-inclusions', [\App\Http\Controllers\Admin\TourController::class, 'inclusionStore'])->name('additional-inclusions.store');
        Route::get('/admin/additional-inclusions/{inclusion}/edit', [\App\Http\Controllers\Admin\TourController::class, 'inclusionEdit'])->name('additional-inclusions.edit');
        Route::put('/admin/additional-inclusions/{inclusion}', [\App\Http\Controllers\Admin\TourController::class, 'inclusionUpdate'])->name('additional-inclusions.update');
        Route::delete('/admin/additional-inclusions/{inclusion}', [\App\Http\Controllers\Admin\TourController::class, 'inclusionDestroy'])->name('additional-inclusions.destroy');
    });

    // Additional Exclusions
    Route::middleware('can:manage_exclusions')->group(function () {
        Route::get('/admin/additional-exclusions', [\App\Http\Controllers\Admin\TourController::class, 'exclusionIndex'])->name('additional-exclusions.index');
        Route::get('/admin/additional-exclusions/create', [\App\Http\Controllers\Admin\TourController::class, 'exclusionCreate'])->name('additional-exclusions.create');
        Route::post('/admin/additional-exclusions', [\App\Http\Controllers\Admin\TourController::class, 'exclusionStore'])->name('additional-exclusions.store');
        Route::get('/admin/additional-exclusions/{exclusion}/edit', [\App\Http\Controllers\Admin\TourController::class, 'exclusionEdit'])->name('additional-exclusions.edit');
        Route::put('/admin/additional-exclusions/{exclusion}', [\App\Http\Controllers\Admin\TourController::class, 'exclusionUpdate'])->name('additional-exclusions.update');
        Route::delete('/admin/additional-exclusions/{exclusion}', [\App\Http\Controllers\Admin\TourController::class, 'exclusionDestroy'])->name('additional-exclusions.destroy');
    });

    // Meals
    Route::middleware('can:manage_meals')->group(function () {
        Route::get('/admin/meals', [\App\Http\Controllers\Admin\TourController::class, 'mealIndex'])->name('meals.index');
        Route::get('/admin/meals/create', [\App\Http\Controllers\Admin\TourController::class, 'mealCreate'])->name('meals.create');
        Route::post('/admin/meals', [\App\Http\Controllers\Admin\TourController::class, 'mealStore'])->name('meals.store');
        Route::get('/admin/meals/{meal}/edit', [\App\Http\Controllers\Admin\TourController::class, 'mealEdit'])->name('meals.edit');
        Route::put('/admin/meals/{meal}', [\App\Http\Controllers\Admin\TourController::class, 'mealUpdate'])->name('meals.update');
        Route::delete('/admin/meals/{meal}', [\App\Http\Controllers\Admin\TourController::class, 'mealDestroy'])->name('meals.destroy');
    });

    // Destinations
    Route::resource('/admin/destinations', \App\Http\Controllers\Admin\DestinationController::class)->except(['show'])->middleware('can:manage_destinations');
    
    // Parent Destinations
    Route::middleware('can:manage_destinations')->group(function () {
        Route::post('/admin/parent-destinations', [\App\Http\Controllers\Admin\DestinationController::class, 'storeParent'])->name('parent-destinations.store');
        Route::get('/admin/parent-destinations/{parentDestination}/edit', [\App\Http\Controllers\Admin\DestinationController::class, 'editParent'])->name('parent-destinations.edit');
        Route::put('/admin/parent-destinations/{parentDestination}', [\App\Http\Controllers\Admin\DestinationController::class, 'updateParent'])->name('parent-destinations.update');
        Route::delete('/admin/parent-destinations/{parentDestination}', [\App\Http\Controllers\Admin\DestinationController::class, 'destroyParent'])->name('parent-destinations.destroy');
    });

    // Travel Guides
    Route::middleware('can:manage_travel_guides')->group(function () {
        Route::resource('/admin/travel-guides', \App\Http\Controllers\Admin\TravelGuideController::class)->except(['show']);
        Route::post('/admin/travel-guides/toggle-status', [\App\Http\Controllers\Admin\TravelGuideController::class, 'toggleStatus'])->name('travel-guides.toggle-status');
    });

    // Categories
    Route::resource('/admin/categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show'])->middleware('can:manage_categories');

    // Hotels
    Route::middleware('can:manage_hotels')->group(function () {
        Route::resource('/admin/hotels', \App\Http\Controllers\Admin\HotelController::class)->except(['show']);
        Route::delete('/admin/hotels/image/{id}', [\App\Http\Controllers\Admin\HotelController::class, 'deleteImage']);
        Route::post('/admin/hotels/{hotel}/rates', [\App\Http\Controllers\Admin\HotelController::class, 'storeRoomRate'])->name('hotels.rates.store');
        Route::delete('/admin/hotels/{hotel}/rates/{rate}', [\App\Http\Controllers\Admin\HotelController::class, 'destroyRoomRate'])->name('hotels.rates.destroy');
    });

    // Activities
    Route::middleware('can:manage_activities')->group(function () {
        Route::resource('/admin/activities', \App\Http\Controllers\Admin\ActivityController::class)->except(['show']);
    });

    // Leads
    Route::middleware('can:manage_leads')->group(function () {
        Route::resource('/admin/leads', \App\Http\Controllers\Admin\LeadController::class)->except(['show']);
    });

    // Vehicles
    Route::resource('/admin/vehicles', \App\Http\Controllers\Admin\VehicleController::class)->except(['show'])->middleware('can:manage_vehicles');

    // Drivers
    Route::resource('/admin/drivers', \App\Http\Controllers\Admin\DriverController::class)->except(['show'])->middleware('can:manage_drivers');

    // Quotations
    Route::post('/admin/quotations/{id}/send-mail', [\App\Http\Controllers\Admin\QuotationController::class, 'sendMail'])->name('admin.quotations.send_mail');
    Route::resource('/admin/quotations', \App\Http\Controllers\Admin\QuotationController::class)->except(['show']);

    // Enquiries
    Route::middleware('can:manage_enquiries')->group(function () {
        Route::get('/admin/enquiries', [\App\Http\Controllers\Admin\EnquiryController::class, 'index']);
        Route::get('/admin/enquiries/{id}', [\App\Http\Controllers\Admin\EnquiryController::class, 'show']);
        Route::delete('/admin/enquiries/{id}', [\App\Http\Controllers\Admin\EnquiryController::class, 'destroy']);
    });
    // User Management
    Route::resource('/admin/roles', \App\Http\Controllers\Admin\RoleController::class)->middleware('can:manage_roles');
    Route::resource('/admin/users', \App\Http\Controllers\Admin\UserController::class)->middleware('can:manage_users');
});

Route::get('/', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/destination', [SiteController::class, 'destination']);
Route::get('/tours', [SiteController::class, 'tours']);
Route::get('/hotel', [SiteController::class, 'hotel']);
Route::get('/blog', [SiteController::class, 'blog']);
Route::get('/blog-single/{slug}', [SiteController::class, 'blogSingle']);
Route::get('/tour/{slug}', [SiteController::class, 'tourDetail']);
Route::get('/contact', [SiteController::class, 'contact']);
Route::get('/enquiry', [SiteController::class, 'enquiry']);
Route::post('/enquiry/submit', [\App\Http\Controllers\EnquiryController::class, 'submit']);
Route::get('/ajax-search', [SiteController::class, 'ajaxSearch'])->name('ajax.search');

Route::get('/{lead_name}/{quotation_code}', [\App\Http\Controllers\Admin\QuotationController::class, 'showPublic'])->name('quotations.public');

