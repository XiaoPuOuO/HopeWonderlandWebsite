<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubBrandController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\ContactOptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 測試路由 - 檢查圖片 URL
Route::get('/test-image-url', function () {
    $files = \Storage::disk('public')->files('brands');
    $result = [];
    
    foreach ($files as $file) {
        $result[] = [
            'file' => $file,
            'url' => \Storage::disk('public')->url($file),
            'absolute_url' => url(\Storage::disk('public')->url($file)),
            'exists' => \Storage::disk('public')->exists($file),
            'size' => \Storage::disk('public')->size($file)
        ];
    }
    
    return response()->json($result);
});

// 首頁路由
Route::get('/', [HomeController::class, 'index'])->name('home');

// 關於我們
Route::get('/about', [HomeController::class, 'about'])->name('about');

// 核心團隊
Route::get('/team', [HomeController::class, 'team'])->name('team');

// 服務項目
Route::get('/services', [HomeController::class, 'services'])->name('services');

// 作品集
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');

// 聯絡我們
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

// 管理後台路由
Route::prefix('admin')->name('admin.')->group(function () {
    // 儀表板
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // 子品牌管理
    Route::resource('sub-brands', SubBrandController::class);
    Route::post('sub-brands/upload-logo', [SubBrandController::class, 'uploadLogo'])->name('sub-brands.upload-logo');
    Route::delete('sub-brands/{subBrand}/logo', [SubBrandController::class, 'deleteLogo'])->name('sub-brands.delete-logo');
    Route::patch('sub-brands/{subBrand}/toggle-status', [SubBrandController::class, 'toggleStatus'])->name('sub-brands.toggle-status');
    
    // 作品集管理
    Route::resource('portfolios', PortfolioController::class);
    Route::post('portfolios/upload-featured-image', [PortfolioController::class, 'uploadFeaturedImage'])->name('portfolios.upload-featured-image');
    Route::delete('portfolios/{portfolio}/featured-image', [PortfolioController::class, 'deleteFeaturedImage'])->name('portfolios.delete-featured-image');
    Route::patch('portfolios/{portfolio}/toggle-featured', [PortfolioController::class, 'toggleFeatured'])->name('portfolios.toggle-featured');
    Route::patch('portfolios/{portfolio}/toggle-status', [PortfolioController::class, 'toggleStatus'])->name('portfolios.toggle-status');
    
    // 團隊成員管理
    Route::resource('team-members', TeamMemberController::class);
    Route::post('team-members/upload-avatar', [TeamMemberController::class, 'uploadAvatar'])->name('team-members.upload-avatar');
    Route::delete('team-members/{teamMember}/avatar', [TeamMemberController::class, 'deleteAvatar'])->name('team-members.delete-avatar');
    Route::patch('team-members/{teamMember}/toggle-status', [TeamMemberController::class, 'toggleStatus'])->name('team-members.toggle-status');
    
    // 聯絡訊息管理
    Route::resource('contact-messages', AdminContactMessageController::class);
    Route::patch('contact-messages/{contactMessage}/mark-read', [AdminContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-read');
    Route::patch('contact-messages/{contactMessage}/mark-unread', [AdminContactMessageController::class, 'markAsUnread'])->name('contact-messages.mark-unread');
    Route::post('contact-messages/bulk-action', [AdminContactMessageController::class, 'bulkAction'])->name('contact-messages.bulk-action');
    Route::get('contact-messages-stats', [AdminContactMessageController::class, 'getStats'])->name('contact-messages.stats');
    
    // 聯絡選項管理
    Route::resource('contact-options', ContactOptionController::class);
    Route::patch('contact-options/{contactOption}/toggle-status', [ContactOptionController::class, 'toggleStatus'])->name('contact-options.toggle-status');
    Route::post('contact-options/bulk-action', [ContactOptionController::class, 'bulkAction'])->name('contact-options.bulk-action');
});
