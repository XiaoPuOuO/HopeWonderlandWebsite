<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\SubBrand;
use App\Models\Portfolio;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * 顯示管理後台儀表板
     */
    public function index()
    {
        // 聯絡訊息統計
        $totalMessages = ContactMessage::count();
        $unreadMessages = ContactMessage::where('is_read', false)->count();
        $todayMessages = ContactMessage::whereDate('created_at', today())->count();
        $thisWeekMessages = ContactMessage::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        
        // 其他統計
        $totalSubBrands = SubBrand::count();
        $activeSubBrands = SubBrand::where('is_active', true)->count();
        $totalPortfolios = Portfolio::count();
        $featuredPortfolios = Portfolio::where('is_featured', true)->count();
        $totalTeamMembers = TeamMember::count();
        $activeTeamMembers = TeamMember::where('is_active', true)->count();
        
        // 最近的聯絡訊息
        $recentMessages = ContactMessage::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // 按來源統計訊息
        $messagesBySource = ContactMessage::selectRaw('source, COUNT(*) as count')
            ->groupBy('source')
            ->get()
            ->pluck('count', 'source');
        
        // 按服務類型統計
        $messagesByService = ContactMessage::selectRaw('service, COUNT(*) as count')
            ->whereNotNull('service')
            ->groupBy('service')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMessages',
            'unreadMessages', 
            'todayMessages',
            'thisWeekMessages',
            'totalSubBrands',
            'activeSubBrands',
            'totalPortfolios',
            'featuredPortfolios',
            'totalTeamMembers',
            'activeTeamMembers',
            'recentMessages',
            'messagesBySource',
            'messagesByService'
        ));
    }
}
