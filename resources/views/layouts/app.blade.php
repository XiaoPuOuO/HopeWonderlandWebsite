<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '《HopeWonderland Studio》')</title>
    <meta name="description" content="@yield('description', 'HopeWonderland Studio - 創意設計工作室')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])
    
    @yield('head')
    @stack('styles')
</head>
<body class="bg-secondary">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <div class="navbar-left">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        <img src="{{ asset('images/icon.png') }}" alt="HopeWonderland Studio" class="brand-logo">
                        <span class="brand-name">HopeWonderland Studio</span>
                    </a>
                </div>
                
                <div class="navbar-nav desktop-nav">
                    <a href="{{ route('home') }}" class="nav-link">首頁</a>
                    <a href="{{ route('about') }}" class="nav-link">關於</a>
                    <div class="nav-dropdown">
                        <button class="nav-link nav-dropdown-toggle">
                            更多 <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="nav-dropdown-menu">
                            <a href="{{ route('team') }}" class="nav-dropdown-link">團隊</a>
                            <a href="{{ route('services') }}" class="nav-dropdown-link">服務</a>
                            <a href="{{ route('portfolio') }}" class="nav-dropdown-link">作品</a>
                            <a href="{{ route('contact') }}" class="nav-dropdown-link">聯絡</a>
                        </div>
                    </div>
                    <button class="theme-toggle" id="theme-toggle" title="切換主題">
                        <i class="fas fa-moon"></i>
                    </button>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-cog"></i>管理
                            </a>
                        @endif
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user"></i>帳號
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">
                                <i class="fas fa-sign-out-alt"></i>登出
                            </button>
                        </form>
                    @else
                        <div class="auth-buttons">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-sign-in-alt"></i>登入
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-user-plus"></i>註冊
                            </a>
                        </div>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="mobile-menu-toggle">
                    <button type="button" class="nav-link" id="mobile-menu-button">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="mobile-menu hidden" id="mobile-menu">
            <div class="mobile-menu-content">
                <a href="{{ route('home') }}" class="mobile-nav-link">首頁</a>
                <a href="{{ route('about') }}" class="mobile-nav-link">關於我們</a>
                <a href="{{ route('team') }}" class="mobile-nav-link">核心團隊</a>
                <a href="{{ route('services') }}" class="mobile-nav-link">服務項目</a>
                <a href="{{ route('portfolio') }}" class="mobile-nav-link">作品集</a>
                <a href="{{ route('contact') }}" class="mobile-nav-link">聯絡我們</a>
                <button class="mobile-nav-link theme-toggle" id="mobile-theme-toggle">
                    <i class="fas fa-moon"></i>切換主題
                </button>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link admin-link">
                            <i class="fas fa-cog"></i>管理後台
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="mobile-nav-link">
                            <i class="fas fa-sign-out-alt"></i>登出
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link">
                        <i class="fas fa-sign-in-alt"></i>會員登入
                    </a>
                    <a href="{{ route('register') }}" class="mobile-nav-link">
                        <i class="fas fa-user-plus"></i>註冊
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-brand">
                        <img src="{{ asset('images/icon.png') }}" alt="HopeWonderland Studio" class="footer-logo">
                        <span class="footer-brand-name">HopeWonderland Studio</span>
                    </div>
                    <p class="footer-description">科技工作室，專精於遊戲開發、SaaS 服務與代工解決方案</p>
                </div>
                
                <div class="footer-section">
                    <h3 class="footer-title">快速連結</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}" class="footer-link">首頁</a></li>
                        <li><a href="{{ route('about') }}" class="footer-link">關於我們</a></li>
                        <li><a href="{{ route('team') }}" class="footer-link">核心團隊</a></li>
                        <li><a href="{{ route('services') }}" class="footer-link">服務項目</a></li>
                        <li><a href="{{ route('portfolio') }}" class="footer-link">作品集</a></li>
                        <li><a href="{{ route('contact') }}" class="footer-link">聯絡我們</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3 class="footer-title">聯絡資訊</h3>
                    <div class="footer-contact">
                        <p><i class="fas fa-envelope"></i>hopewonderlandteam@gmail.com</p>
                        <p><i class="fas fa-phone"></i>+886 02 8982 5981</p>
                        <div class="social-links">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} HopeWonderland Studio. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Vite JS - 確保主題切換功能總是載入 -->
    @vite(['resources/js/app.js', 'resources/js/global.js'])
    
    @stack('scripts')
</body>
</html>
