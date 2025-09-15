<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>《HopeWonderland Studio》</title>
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
    @vite(['resources/css/app.css', 'resources/css/admin.css'])
    
    @yield('head')
    @stack('styles')
</head>
<body class="bg-secondary">
    <div class="admin-layout">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-brand">
                <div class="flex items-center">
                    <img src="{{ asset('images/icon.png') }}" alt="HopeWonderland Studio" class="rounded-lg" style="height: 2.5rem; width: 2.5rem; margin-right: 0.75rem;">
                    <div>
                        <h1 class="text-lg font-bold">管理後台</h1>
                        <p class="text-sm text-secondary">HopeWonderland Studio</p>
                    </div>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>儀表板</span>
                </a>
                
                <a href="{{ route('admin.sub-brands.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.sub-brands.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>子品牌網站管理</span>
                </a>
                
                <a href="{{ route('admin.portfolios.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.portfolios.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i>
                    <span>作品集管理</span>
                </a>
                
                <a href="{{ route('admin.team-members.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.team-members.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>團隊成員管理</span>
                </a>
                
                <a href="{{ route('admin.contact-messages.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>聯絡訊息管理</span>
                    @php
                        $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="nav-badge">{{ $unreadCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.contact-options.index') }}" 
                   class="nav-link {{ request()->routeIs('admin.contact-options.*') ? 'active' : '' }}">
                    <i class="fas fa-cogs"></i>
                    <span>聯絡選項管理</span>
                </a>
                
                <a href="{{ route('home') }}" 
                   class="nav-link">
                    <i class="fas fa-home"></i>
                    <span>返回首頁</span>
                </a>
                
                <button class="nav-link theme-toggle" id="admin-theme-toggle">
                    <i class="fas fa-moon"></i>
                    <span>切換主題</span>
                </button>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="admin-header-content">
                    <div>
                        <h2 class="admin-page-title">@yield('page-title', '管理後台')</h2>
                        <p class="admin-page-description">{{ date('Y年m月d日') }}</p>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="admin-content">
                @if(session('success'))
                    <div class="admin-notification admin-notification-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button class="admin-notification-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="admin-notification admin-notification-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                        <button class="admin-notification-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Vite JS - 確保主題切換功能總是載入 -->
    @vite(['resources/js/app.js', 'resources/js/global.js'])
    
    @stack('scripts')
</body>
</html>
