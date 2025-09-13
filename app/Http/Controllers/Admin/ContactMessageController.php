<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * 顯示聯絡訊息列表
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // 搜尋功能
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // 篩選已讀/未讀
        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->where('is_read', true);
            } elseif ($request->status === 'unread') {
                $query->where('is_read', false);
            }
        }

        // 篩選來源
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // 排序
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $messages = $query->paginate(20);

        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * 顯示單一聯絡訊息
     */
    public function show(ContactMessage $contactMessage)
    {
        // 標記為已讀
        if (!$contactMessage->is_read) {
            $contactMessage->markAsRead();
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * 標記訊息為已讀
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->markAsRead();

        return response()->json([
            'success' => true,
            'message' => '訊息已標記為已讀'
        ]);
    }

    /**
     * 標記訊息為未讀
     */
    public function markAsUnread(ContactMessage $contactMessage)
    {
        $contactMessage->markAsUnread();

        return response()->json([
            'success' => true,
            'message' => '訊息已標記為未讀'
        ]);
    }

    /**
     * 刪除聯絡訊息
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return response()->json([
            'success' => true,
            'message' => '訊息已刪除'
        ]);
    }

    /**
     * 批量操作
     */
    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => '請選擇要操作的訊息'
            ], 400);
        }

        switch ($action) {
            case 'mark_read':
                ContactMessage::whereIn('id', $ids)->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);
                $message = '已標記為已讀';
                break;

            case 'mark_unread':
                ContactMessage::whereIn('id', $ids)->update([
                    'is_read' => false,
                    'read_at' => null
                ]);
                $message = '已標記為未讀';
                break;

            case 'delete':
                ContactMessage::whereIn('id', $ids)->delete();
                $message = '已刪除';
                break;

            default:
                return response()->json([
                    'success' => false,
                    'message' => '無效的操作'
                ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * 獲取統計資料
     */
    public function getStats()
    {
        $total = ContactMessage::count();
        $unread = ContactMessage::where('is_read', false)->count();
        $read = ContactMessage::where('is_read', true)->count();
        $today = ContactMessage::whereDate('created_at', today())->count();
        $thisWeek = ContactMessage::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $thisMonth = ContactMessage::whereMonth('created_at', now()->month)->count();

        return response()->json([
            'total' => $total,
            'unread' => $unread,
            'read' => $read,
            'today' => $today,
            'thisWeek' => $thisWeek,
            'thisMonth' => $thisMonth,
        ]);
    }
}
