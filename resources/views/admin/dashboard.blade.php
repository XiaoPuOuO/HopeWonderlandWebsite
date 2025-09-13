@extends('layouts.admin')


@section('head')
    @vite(['resources/css/dashboard.css', 'resources/css/dashboard-detail.css', 'resources/js/dashboard.js'])
@endsection

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">管理後台儀表板</h1>
        <p class="admin-description">歡迎回來！這裡是您的管理控制中心</p>
    </div>
</div>

<div class="admin-content">
    <!-- 統計卡片 -->
    <div class="stats-grid">
        <!-- 聯絡訊息統計 -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $totalMessages }}</h3>
                <p class="stat-label">總聯絡訊息</p>
                <div class="stat-details">
                    <span class="stat-detail-item">
                        <i class="fas fa-envelope-open text-danger"></i>
                        未讀: {{ $unreadMessages }}
                    </span>
                    <span class="stat-detail-item">
                        <i class="fas fa-envelope-open text-success"></i>
                        已讀: {{ $readMessages }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 子品牌統計 -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $totalSubBrands }}</h3>
                <p class="stat-label">子品牌網站</p>
                <div class="stat-details">
                    <span class="stat-detail-item">
                        <i class="fas fa-check-circle text-success"></i>
                        啟用: {{ $activeSubBrands }}
                    </span>
                    <span class="stat-detail-item">
                        <i class="fas fa-times-circle text-secondary"></i>
                        停用: {{ $inactiveSubBrands }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 作品集統計 -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $totalPortfolios }}</h3>
                <p class="stat-label">作品集項目</p>
                <div class="stat-details">
                    <span class="stat-detail-item">
                        <i class="fas fa-star text-warning"></i>
                        精選: {{ $featuredPortfolios }}
                    </span>
                    <span class="stat-detail-item">
                        <i class="fas fa-eye text-primary"></i>
                        公開: {{ $activePortfolios }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 團隊成員統計 -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $totalTeamMembers }}</h3>
                <p class="stat-label">團隊成員</p>
                <div class="stat-details">
                    <span class="stat-detail-item">
                        <i class="fas fa-user-check text-success"></i>
                        在職: {{ $activeTeamMembers }}
                    </span>
                    <span class="stat-detail-item">
                        <i class="fas fa-user-times text-secondary"></i>
                        離職: {{ $inactiveTeamMembers }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 儀表板網格 -->
    <div class="dashboard-grid">
        <!-- 最新聯絡訊息 -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">
                    <i class="fas fa-envelope"></i>
                    最新聯絡訊息
                </h3>
                <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm btn-primary">
                    查看全部
                </a>
            </div>
            <div class="dashboard-card-content">
                @if($recentMessages->count() > 0)
                    <div class="message-list">
                        @foreach($recentMessages as $message)
                            <div class="message-item {{ !$message->is_read ? 'unread' : '' }}">
                                <div class="message-info">
                                    <div class="message-header">
                                        <h4 class="message-name">{{ $message->name }}</h4>
                                        <span class="message-source source-{{ $message->source }}">
                                            {{ $message->source === 'contact' ? '聯絡頁面' : '首頁' }}
                                        </span>
                                    </div>
                                    <p class="message-preview">{{ Str::limit($message->message, 80) }}</p>
                                    <div class="message-meta">
                                        <span>{{ $message->created_at->format('m/d H:i') }}</span>
                                        @if($message->service_type)
                                            <span class="message-service">{{ $message->service_type }}</span>
                                        @endif
                                        @if($message->budget_range)
                                            <span class="message-service">{{ $message->budget_range }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="message-actions">
                                    <a href="{{ route('admin.contact-messages.show', $message) }}" class="btn btn-sm btn-outline-primary">
                                        查看
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>暫無聯絡訊息</h3>
                        <p>目前還沒有收到任何聯絡訊息</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- 聯絡訊息統計圖表 -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">
                    <i class="fas fa-chart-bar"></i>
                    本月聯絡訊息統計
                </h3>
            </div>
            <div class="dashboard-card-content">
                <div class="chart-container">
                    @foreach($monthlyStats as $stat)
                        <div class="chart-item">
                            <div class="chart-label">
                                <span>{{ $stat['label'] }}</span>
                            </div>
                            <div class="chart-bar">
                                <div class="chart-fill" style="width: {{ $stat['percentage'] }}%"></div>
                            </div>
                            <div class="chart-value">{{ $stat['count'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 快速操作 -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">
                    <i class="fas fa-bolt"></i>
                    快速操作
                </h3>
            </div>
            <div class="dashboard-card-content">
                <div class="quick-actions">
                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-primary btn-block mb-3">
                        <i class="fas fa-envelope"></i> 管理聯絡訊息
                    </a>
                    <a href="{{ route('admin.sub-brands.create') }}" class="btn btn-success btn-block mb-3">
                        <i class="fas fa-plus"></i> 新增子品牌
                    </a>
                    <a href="{{ route('admin.portfolios.create') }}" class="btn btn-info btn-block mb-3">
                        <i class="fas fa-plus"></i> 新增作品集
                    </a>
                    <a href="{{ route('admin.team-members.create') }}" class="btn btn-warning btn-block">
                        <i class="fas fa-plus"></i> 新增團隊成員
                    </a>
                </div>
            </div>
        </div>

        <!-- 系統狀態 -->
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h3 class="dashboard-card-title">
                    <i class="fas fa-server"></i>
                    系統狀態
                </h3>
            </div>
            <div class="dashboard-card-content">
                <div class="system-status">
                    <div class="status-item">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>系統運行正常</span>
                    </div>
                    <div class="status-item">
                        <i class="fas fa-database text-info"></i>
                        <span>數據庫連接正常</span>
                    </div>
                    <div class="status-item">
                        <i class="fas fa-hdd text-primary"></i>
                        <span>存儲空間充足</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection