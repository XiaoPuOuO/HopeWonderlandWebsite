<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * 顯示登入表單
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * 處理登入請求
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // 根據用戶權限決定跳轉位置
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                return redirect()->intended(route('user.dashboard'));
            }
        }

        throw ValidationException::withMessages([
            'email' => '提供的憑證與我們的記錄不符。',
        ]);
    }

    /**
     * 處理登出請求
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
