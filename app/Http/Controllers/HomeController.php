<?php

namespace App\Http\Controllers;

use App\Models\SubBrand;
use App\Models\TeamMember;
use App\Models\Portfolio;
use App\Models\ContactOption;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * 顯示首頁
     */
    public function index()
    {
        $subBrands = SubBrand::active()->ordered()->get();
        $serviceOptions = ContactOption::getServiceOptions();
        $budgetOptions = ContactOption::getBudgetOptions();
        
        return view('home', compact('subBrands', 'serviceOptions', 'budgetOptions'));
    }

    public function about()
    {
        return view('about');
    }

    public function team()
    {
        $teamMembers = TeamMember::active()->ordered()->get();
        return view('team', compact('teamMembers'));
    }

    public function services()
    {
        return view('services');
    }

    public function portfolio()
    {
        $portfolios = Portfolio::active()->ordered()->get();
        
        // 獲取所有存在的分類，如果沒有作品集則使用預設分類
        $categories = $portfolios->count() > 0 
            ? $portfolios->pluck('category')->unique()->toArray()
            : ['game', 'saas', 'web', 'mobile']; // 預設分類
        
        return view('portfolio', compact('portfolios', 'categories'));
    }

    public function contact()
    {
        $serviceOptions = ContactOption::getServiceOptions();
        $budgetOptions = ContactOption::getBudgetOptions();
        
        return view('contact', compact('serviceOptions', 'budgetOptions'));
    }
}
