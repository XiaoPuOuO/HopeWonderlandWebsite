<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubBrand;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubBrandController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * 顯示子品牌列表
     */
    public function index()
    {
        $subBrands = SubBrand::ordered()->get();
        
        return view('admin.sub-brands.index', compact('subBrands'));
    }

    /**
     * 顯示創建子品牌表單
     */
    public function create()
    {
        return view('admin.sub-brands.create');
    }

    /**
     * 儲存新創建的子品牌
     */
    public function store(Request $request)
    {
        // 動態驗證規則
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sub_brands,slug',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url',
            'color_primary' => 'nullable|string|max:7',
            'color_secondary' => 'nullable|string|max:7',
            'tags' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
        
        // 如果上傳了文件，驗證為圖片；否則驗證為字符串路徑
        if ($request->hasFile('logo')) {
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,gif,webp|max:5120';
        } else {
            $rules['logo'] = 'nullable|string|max:255';
        }
        
        $validated = $request->validate($rules);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // 處理圖片上傳和刪除
        if ($request->hasFile('logo')) {
            try {
                $result = $this->imageService->processUploadedImage($request->file('logo'), 'brands');
                $validated['logo'] = $result['path'];
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', '圖片上傳失敗：' . $e->getMessage());
            }
        } elseif ($request->has('logo') && $request->input('logo') === '__DELETE__') {
            // 用戶選擇不設置 Logo
            $validated['logo'] = null;
        } elseif ($request->has('logo') && !empty($request->input('logo')) && $request->input('logo') !== '__DELETE__') {
            // Logo 已經通過 AJAX 上傳，路徑已經在 validated 中
            // 不需要額外處理，保持現有的路徑
        }

        SubBrand::create($validated);

        return redirect()->route('admin.sub-brands.index')
            ->with('success', '子品牌創建成功！');
    }

    /**
     * 顯示指定的子品牌
     */
    public function show(SubBrand $subBrand)
    {
        return view('admin.sub-brands.show', compact('subBrand'));
    }

    /**
     * 顯示編輯子品牌表單
     */
    public function edit(SubBrand $subBrand)
    {
        return view('admin.sub-brands.edit', compact('subBrand'));
    }

    /**
     * 更新指定的子品牌
     */
    public function update(Request $request, SubBrand $subBrand)
    {
        // 動態驗證規則
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sub_brands,slug,' . $subBrand->id,
            'description' => 'nullable|string',
            'website_url' => 'nullable|url',
            'color_primary' => 'nullable|string|max:7',
            'color_secondary' => 'nullable|string|max:7',
            'tags' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
        
        // 如果上傳了文件，驗證為圖片；否則驗證為字符串路徑
        if ($request->hasFile('logo')) {
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,gif,webp|max:5120';
        } else {
            $rules['logo'] = 'nullable|string|max:255';
        }
        
        $validated = $request->validate($rules);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // 處理圖片上傳和刪除
        if ($request->hasFile('logo')) {
            try {
                // 刪除舊的圖片
                if ($subBrand->logo) {
                    $this->imageService->deleteImage($subBrand->logo);
                }
                
                // 處理新圖片
                $result = $this->imageService->processUploadedImage($request->file('logo'), 'brands');
                $validated['logo'] = $result['path'];
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', '圖片上傳失敗：' . $e->getMessage());
            }
        } elseif ($request->has('logo') && $request->input('logo') === '__DELETE__') {
            // 用戶手動刪除了 Logo（通過前端刪除按鈕）
            if ($subBrand->logo) {
                 $this->imageService->deleteImage($subBrand->logo);
                $validated['logo'] = null;
            }
        } elseif ($request->has('logo') && !empty($request->input('logo')) && $request->input('logo') !== '__DELETE__') {
            // Logo 已經通過 AJAX 上傳，路徑已經在 validated 中
            // 檢查是否需要清理舊的 Logo
            if ($subBrand->logo && $subBrand->logo !== $request->input('logo')) {
                $this->imageService->deleteImage($subBrand->logo);
            }
        }

        $subBrand->update($validated);

        return redirect()->route('admin.sub-brands.index')
            ->with('success', '子品牌更新成功！');
    }

    /**
     * 刪除指定的子品牌
     */
    public function destroy(SubBrand $subBrand)
    {
        $subBrandName = $subBrand->name;
        $subBrand->delete();

        // 如果是 AJAX 請求，返回 JSON 響應
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '子品牌刪除成功！',
                'data' => [
                    'id' => $subBrand->id,
                    'name' => $subBrandName
                ]
            ]);
        }

        // 傳統表單提交，重定向
        return redirect()->route('admin.sub-brands.index')
            ->with('success', '子品牌刪除成功！');
    }

    /**
     * 上傳品牌 Logo
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,gif,webp|max:5120'
        ]);

        try {
            $result = $this->imageService->processUploadedImage($request->file('logo'), 'brands');
            
            return response()->json([
                'success' => true,
                'message' => 'Logo 上傳成功！',
                'data' => [
                    'path' => $result['path'],
                    'url' => $result['url'],
                    'filename' => $result['filename'],
                    'original_size' => $result['original_size'],
                    'processed_size' => $result['processed_size'],
                    'file_size' => $result['file_size']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logo 上傳失敗：' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * 刪除品牌 Logo
     */
    public function deleteLogo(Request $request, SubBrand $subBrand)
    {
        if (!$subBrand->logo) {
            return response()->json([
                'success' => false,
                'message' => '沒有找到要刪除的 Logo'
            ], 404);
        }

        try {
            $this->imageService->deleteImage($subBrand->logo);
            $subBrand->update(['logo' => null]);
            
            return response()->json([
                'success' => true,
                'message' => 'Logo 刪除成功！'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logo 刪除失敗：' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 切換子品牌狀態
     */
    public function toggleStatus(Request $request, SubBrand $subBrand)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        try {
            $oldStatus = $subBrand->is_active;
            $newStatus = $request->input('is_active');
            
            $subBrand->update(['is_active' => $newStatus]);
            
            $statusText = $newStatus ? '啟用' : '停用';
            
            return response()->json([
                'success' => true,
                'message' => "子品牌「{$subBrand->name}」已{$statusText}",
                'data' => [
                    'id' => $subBrand->id,
                    'is_active' => $newStatus,
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
