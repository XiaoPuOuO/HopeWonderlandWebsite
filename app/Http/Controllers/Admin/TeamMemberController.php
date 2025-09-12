<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamMemberController extends Controller
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
        $teamMembers = TeamMember::orderBy('sort_order')->orderBy('name')->paginate(10);
        return view('admin.team-members.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.team-members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'social_links' => 'nullable|array',
            'social_links.linkedin' => 'nullable|url',
            'social_links.github' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.website' => 'nullable|url',
            'email' => 'nullable|email|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // 處理頭像
        if ($request->hasFile('avatar')) {
            $imagePath = $this->imageService->processUploadedImage(
                $request->file('avatar'),
                'team',
                300,
                300
            );
            $data['avatar'] = $imagePath;
        }

        // 處理 JSON 欄位
        $data['skills'] = $request->input('skills', []);
        $data['social_links'] = $request->input('social_links', []);
        $data['is_active'] = $request->has('is_active');

        TeamMember::create($data);

        return redirect()->route('admin.team-members.index')
            ->with('success', '團隊成員已成功創建！');
    }

    /**
     * Display the specified resource.
     */
    public function show(TeamMember $teamMember)
    {
        return view('admin.team-members.show', compact('teamMember'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamMember $teamMember)
    {
        return view('admin.team-members.edit', compact('teamMember'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'social_links' => 'nullable|array',
            'social_links.linkedin' => 'nullable|url',
            'social_links.github' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.website' => 'nullable|url',
            'email' => 'nullable|email|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // 處理頭像
        if ($request->hasFile('avatar')) {
            // 刪除舊頭像
            if ($teamMember->avatar) {
                // 如果 avatar 是陣列（新格式），刪除 path
                if (is_array($teamMember->avatar) && isset($teamMember->avatar['path'])) {
                    $this->imageService->deleteImage($teamMember->avatar['path']);
                }
                // 如果 avatar 是字串（舊格式），保持向後兼容
                elseif (is_string($teamMember->avatar)) {
                    $this->imageService->deleteImage($teamMember->avatar);
                }
            }
            
            $imagePath = $this->imageService->processUploadedImage(
                $request->file('avatar'),
                'team',
                300,
                300
            );
            $data['avatar'] = $imagePath;
        }

        // 處理 JSON 欄位
        $data['skills'] = $request->input('skills', []);
        $data['social_links'] = $request->input('social_links', []);
        $data['is_active'] = $request->has('is_active');

        $teamMember->update($data);

        return redirect()->route('admin.team-members.index')
            ->with('success', '團隊成員已成功更新！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamMember $teamMember)
    {
        // 刪除頭像
        if ($teamMember->avatar) {
            // 如果 avatar 是陣列（新格式），刪除 path
            if (is_array($teamMember->avatar) && isset($teamMember->avatar['path'])) {
                $this->imageService->deleteImage($teamMember->avatar['path']);
            }
            // 如果 avatar 是字串（舊格式），保持向後兼容
            elseif (is_string($teamMember->avatar)) {
                $this->imageService->deleteImage($teamMember->avatar);
            }
        }

        $teamMember->delete();

        return redirect()->route('admin.team-members.index')
            ->with('success', '團隊成員已成功刪除！');
    }

    /**
     * Upload avatar via AJAX
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $imagePath = $this->imageService->processUploadedImage(
                $request->file('avatar'),
                'team',
                300,
                300
            );

            return response()->json([
                'success' => true,
                'message' => '頭像上傳成功！',
                'data' => [
                    'path' => $imagePath,
                    'url' => '/storage/' . $imagePath
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '頭像上傳失敗：' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete avatar via AJAX
     */
    public function deleteAvatar(Request $request, TeamMember $teamMember)
    {
        try {
            if ($teamMember->avatar) {
                // 如果 avatar 是陣列（新格式），刪除 path
                if (is_array($teamMember->avatar) && isset($teamMember->avatar['path'])) {
                    $this->imageService->deleteImage($teamMember->avatar['path']);
                }
                // 如果 avatar 是字串（舊格式），保持向後兼容
                elseif (is_string($teamMember->avatar)) {
                    $this->imageService->deleteImage($teamMember->avatar);
                }
                $teamMember->update(['avatar' => null]);
            }

            return response()->json([
                'success' => true,
                'message' => '頭像已成功刪除！'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '頭像刪除失敗：' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle active status via AJAX
     */
    public function toggleStatus(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        try {
            $teamMember->update(['is_active' => $request->input('is_active')]);
            
            $statusText = $request->input('is_active') ? '啟用' : '停用';
            
            return response()->json([
                'success' => true,
                'message' => "團隊成員「{$teamMember->name}」已{$statusText}",
                'data' => [
                    'id' => $teamMember->id,
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
