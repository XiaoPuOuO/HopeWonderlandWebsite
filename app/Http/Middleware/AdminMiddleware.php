<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 檢查用戶是否已登入
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', '請先登入');
        }

        // 檢查用戶是否為管理員
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', '您沒有權限訪問管理後台');
        }

        return $next($request);
    }
}
