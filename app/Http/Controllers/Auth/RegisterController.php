<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * 顯示註冊表單
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * 處理註冊請求
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required' => '請輸入您的姓名',
            'name.max' => '姓名不能超過255個字符',
            'email.required' => '請輸入您的電子郵件',
            'email.email' => '請輸入有效的電子郵件格式',
            'email.unique' => '此電子郵件已被註冊',
            'password.required' => '請輸入密碼',
            'password.confirmed' => '密碼確認不符',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => false, // 新註冊的用戶預設為一般用戶
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', '註冊成功！歡迎加入 HopeWonderland Studio！');
    }
}
