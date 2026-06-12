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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    
    // Settings
    Route::get('/admin/settings/company', [CompanySettingController::class, 'index']);
    Route::post('/admin/settings/company', [CompanySettingController::class, 'update']);
    Route::get('/admin/settings/policies', [CompanySettingController::class, 'editPolicies']);
    Route::post('/admin/settings/policies', [CompanySettingController::class, 'updatePolicies']);
    Route::get('/admin/settings/smtp', [SmtpSettingController::class, 'index']);
    Route::post('/admin/settings/smtp', [SmtpSettingController::class, 'update']);
    Route::resource('/admin/settings/slider', \App\Http\Controllers\Admin\WebsiteController::class)->except(['show']);
    Route::get('/admin/settings/testimonial', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialIndex']);
    Route::get('/admin/settings/testimonial/create', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialCreate']);
    Route::post('/admin/settings/testimonial', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialStore']);
    Route::get('/admin/settings/testimonial/{testimonial}/edit', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialEdit']);
    Route::put('/admin/settings/testimonial/{testimonial}', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialUpdate']);
    Route::delete('/admin/settings/testimonial/{testimonial}', [\App\Http\Controllers\Admin\WebsiteController::class, 'testimonialDestroy']);

    // Blogs
    Route::resource('/admin/blogs', \App\Http\Controllers\Admin\BlogController::class)->except(['show']);
    Route::delete('/admin/blogs/image/{id}', [\App\Http\Controllers\Admin\BlogController::class, 'deleteImage']);

    // FAQs
    Route::resource('/admin/faqs', \App\Http\Controllers\Admin\FaqController::class)->except(['show']);

    // Tours
    Route::resource('/admin/tours', \App\Http\Controllers\Admin\TourController::class)->except(['show']);
    Route::delete('/admin/tours/image/{id}', [\App\Http\Controllers\Admin\TourController::class, 'deleteImage']);

    // Additional Inclusions
    Route::get('/admin/additional-inclusions', [\App\Http\Controllers\Admin\TourController::class, 'inclusionIndex'])->name('additional-inclusions.index');
    Route::get('/admin/additional-inclusions/create', [\App\Http\Controllers\Admin\TourController::class, 'inclusionCreate'])->name('additional-inclusions.create');
    Route::post('/admin/additional-inclusions', [\App\Http\Controllers\Admin\TourController::class, 'inclusionStore'])->name('additional-inclusions.store');
    Route::get('/admin/additional-inclusions/{inclusion}/edit', [\App\Http\Controllers\Admin\TourController::class, 'inclusionEdit'])->name('additional-inclusions.edit');
    Route::put('/admin/additional-inclusions/{inclusion}', [\App\Http\Controllers\Admin\TourController::class, 'inclusionUpdate'])->name('additional-inclusions.update');
    Route::delete('/admin/additional-inclusions/{inclusion}', [\App\Http\Controllers\Admin\TourController::class, 'inclusionDestroy'])->name('additional-inclusions.destroy');

    // Destinations
    Route::resource('/admin/destinations', \App\Http\Controllers\Admin\DestinationController::class)->except(['show']);

    // Categories
    Route::resource('/admin/categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
});

Route::get('/', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/destination', [SiteController::class, 'destination']);
Route::get('/hotel', [SiteController::class, 'hotel']);
Route::get('/blog', [SiteController::class, 'blog']);
Route::get('/blog-single/{slug}', [SiteController::class, 'blogSingle']);
Route::get('/tour/{slug}', [SiteController::class, 'tourDetail']);
Route::get('/contact', [SiteController::class, 'contact']);
