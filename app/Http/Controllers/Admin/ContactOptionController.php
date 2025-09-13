<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactOption;
use Illuminate\Http\Request;

class ContactOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceOptions = ContactOption::where('type', 'service')->orderBy('sort_order')->get();
        $budgetOptions = ContactOption::where('type', 'budget')->orderBy('sort_order')->get();
        
        return view('admin.contact-options.index', compact('serviceOptions', 'budgetOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact-options.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:service,budget',
            'value' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        // 檢查是否已存在相同的 type 和 value
        $existing = ContactOption::where('type', $request->type)
                                ->where('value', $request->value)
                                ->exists();
        
        if ($existing) {
            return back()->withErrors(['value' => '此選項值已存在']);
        }

        ContactOption::create([
            'type' => $request->type,
            'value' => $request->value,
            'label' => $request->label,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true
        ]);

        return redirect()->route('admin.contact-options.index')
                        ->with('success', '選項已成功新增');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contactOption = ContactOption::findOrFail($id);
        return view('admin.contact-options.edit', compact('contactOption'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:service,budget',
            'value' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $contactOption = ContactOption::findOrFail($id);
        
        // 檢查是否已存在相同的 type 和 value（排除自己）
        $existing = ContactOption::where('type', $request->type)
                                ->where('value', $request->value)
                                ->where('id', '!=', $contactOption->id)
                                ->exists();
        
        if ($existing) {
            return back()->withErrors(['value' => '此選項值已存在']);
        }

        $contactOption->update([
            'type' => $request->type,
            'value' => $request->value,
            'label' => $request->label,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.contact-options.index')
                        ->with('success', '選項已成功更新');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $contactOption = ContactOption::find($id);
            
            if (!$contactOption) {
                return response()->json([
                    'success' => false,
                    'message' => '找不到指定的選項'
                ], 404);
            }
            
            $contactOption->delete();

            return response()->json([
                'success' => true,
                'message' => '選項已成功刪除'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刪除失敗，請稍後再試'
            ], 500);
        }
    }

    /**
     * 切換選項狀態
     */
    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate'
        ]);

        $contactOption = ContactOption::findOrFail($id);
        $action = $request->action;
        
        if ($action === 'activate') {
            $contactOption->update(['is_active' => true]);
            $message = '選項已啟用';
        } else {
            $contactOption->update(['is_active' => false]);
            $message = '選項已停用';
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * 批量操作
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'ids' => 'required|array',
            'ids.*' => 'exists:contact_options,id'
        ]);

        $ids = $request->ids;
        $action = $request->action;

        switch ($action) {
            case 'delete':
                ContactOption::whereIn('id', $ids)->delete();
                $message = '選項已成功刪除';
                break;
            case 'activate':
                ContactOption::whereIn('id', $ids)->update(['is_active' => true]);
                $message = '選項已啟用';
                break;
            case 'deactivate':
                ContactOption::whereIn('id', $ids)->update(['is_active' => false]);
                $message = '選項已停用';
                break;
        }

        return response()->json(['success' => true, 'message' => $message]);
    }
}
