<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portfolios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'category' => 'required|string|in:game,saas,web,mobile',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:50',
            'project_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'team_size' => 'nullable|integer|min:1',
            'duration_months' => 'nullable|integer|min:1',
            'client_info' => 'nullable|array',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:30',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // 處理特色圖片
        if ($request->hasFile('featured_image')) {
            $imagePath = $this->imageService->processUploadedImage(
                $request->file('featured_image'),
                'portfolios',
                800,
                600
            );
            $data['featured_image'] = $imagePath;
        }

        // 處理 JSON 欄位
        $data['technologies'] = $request->input('technologies', []);
        $data['client_info'] = $request->input('client_info', []);
        $data['tags'] = $request->input('tags', []);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        Portfolio::create($data);

        return redirect()->route('admin.portfolios.index')
            ->with('success', '作品集已成功創建！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        return view('admin.portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'category' => 'required|string|in:game,saas,web,mobile',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:50',
            'project_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'team_size' => 'nullable|integer|min:1',
            'duration_months' => 'nullable|integer|min:1',
            'client_info' => 'nullable|array',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:30',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // 處理特色圖片
        if ($request->hasFile('featured_image')) {
            // 刪除舊圖片
            if ($portfolio->featured_image) {
                $this->imageService->deleteImage($portfolio->featured_image);
            }
            
            $imagePath = $this->imageService->processUploadedImage(
                $request->file('featured_image'),
                'portfolios',
                800,
                600
            );
            $data['featured_image'] = $imagePath;
        }

        // 處理 JSON 欄位
        $data['technologies'] = $request->input('technologies', []);
        $data['client_info'] = $request->input('client_info', []);
        $data['tags'] = $request->input('tags', []);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        $portfolio->update($data);

        return redirect()->route('admin.portfolios.index')
            ->with('success', '作品集已成功更新！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        // 刪除特色圖片
        if ($portfolio->featured_image) {
            $this->imageService->deleteImage($portfolio->featured_image);
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')
            ->with('success', '作品集已成功刪除！');
    }

    /**
     * Upload featured image via AJAX
     */
    public function uploadFeaturedImage(Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $imagePath = $this->imageService->processUploadedImage(
                $request->file('featured_image'),
                'portfolios',
                800,
                600
            );

            return response()->json([
                'success' => true,
                'message' => '圖片上傳成功！',
                'data' => [
                    'path' => $imagePath,
                    'url' => '/storage/' . $imagePath
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '圖片上傳失敗：' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete featured image via AJAX
     */
    public function deleteFeaturedImage(Request $request, Portfolio $portfolio)
    {
        try {
            if ($portfolio->featured_image) {
                $this->imageService->deleteImage($portfolio->featured_image);
                $portfolio->update(['featured_image' => null]);
            }

            return response()->json([
                'success' => true,
                'message' => '圖片已成功刪除！'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '圖片刪除失敗：' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle featured status via AJAX
     */
    public function toggleFeatured(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'is_featured' => 'required|boolean'
        ]);

        try {
            $portfolio->update(['is_featured' => $request->input('is_featured')]);
            
            $statusText = $request->input('is_featured') ? '設為精選' : '取消精選';
            
            return response()->json([
                'success' => true,
                'message' => "作品集「{$portfolio->title}」已{$statusText}",
                'data' => [
                    'id' => $portfolio->id,
                    'is_featured' => $request->input('is_featured'),
                    'status_text' => $statusText
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '狀態切換失敗：' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle active status via AJAX
     */
    public function toggleStatus(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        try {
            $portfolio->update(['is_active' => $request->input('is_active')]);
            
            $statusText = $request->input('is_active') ? '啟用' : '停用';
            
            return response()->json([
                'success' => true,
                'message' => "作品集「{$portfolio->title}」已{$statusText}",
                'data' => [
                    'id' => $portfolio->id,
                    'is_active' => $request->input('is_active'),
                    'status_text' => $statusText
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '狀態切換失敗：' . $e->getMessage()
            ], 500);
        }
    }
}
