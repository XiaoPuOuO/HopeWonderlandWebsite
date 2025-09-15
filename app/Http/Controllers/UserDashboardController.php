<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserDashboardController extends Controller
{
    /**
     * 顯示用戶儀表板
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('user.dashboard', compact('user'));
    }
    
    /**
     * 顯示用戶資料編輯頁面
     */
    public function edit()
    {
        $user = Auth::user();
        
        return view('user.edit', compact('user'));
    }
    
    /**
     * 更新用戶資料
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('user.dashboard')->with('success', '個人資料已更新！');
    }
    
    /**
     * 顯示密碼修改頁面
     */
    public function editPassword()
    {
        return view('user.edit-password');
    }
    
    /**
     * 更新密碼
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('user.dashboard')->with('success', '密碼已更新！');
    }
}
