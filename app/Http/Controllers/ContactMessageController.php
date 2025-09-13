<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactMessageController extends Controller
{
    /**
     * 儲存聯絡訊息
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'service' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
            'source' => 'nullable|string|in:contact,home',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '請檢查輸入的資料',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'service' => $request->service,
                'budget' => $request->budget,
                'timeline' => $request->timeline,
                'message' => $request->message,
                'source' => $request->source ?? 'contact',
            ]);

            return response()->json([
                'success' => true,
                'message' => '訊息已成功發送！我們會盡快與您聯繫。',
                'data' => $contactMessage
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '發送失敗，請稍後再試。',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
