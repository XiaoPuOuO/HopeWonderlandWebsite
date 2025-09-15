@extends('layouts.app')

@section('title', '我的帳號')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fas fa-user"></i> 我的帳號
                    </h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">
                                    <i class="fas fa-user-circle"></i>
                                    <h3>個人資料</h3>
                                </div>
                                <div class="info-card-content">
                                    <div class="info-item">
                                        <label>姓名</label>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>電子郵件</label>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>註冊時間</label>
                                        <span>{{ $user->created_at->format('Y年m月d日 H:i') }}</span>
                                    </div>
                                    @if($user->email_verified_at)
                                        <div class="info-item">
                                            <label>郵件驗證</label>
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i> 已驗證
                                            </span>
                                        </div>
                                    @else
                                        <div class="info-item">
                                            <label>郵件驗證</label>
                                            <span class="text-warning">
                                                <i class="fas fa-exclamation-triangle"></i> 未驗證
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="info-card-footer">
                                    <a href="{{ route('user.edit') }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> 編輯資料
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">
                                    <i class="fas fa-shield-alt"></i>
                                    <h3>帳號安全</h3>
                                </div>
                                <div class="info-card-content">
                                    <div class="info-item">
                                        <label>帳號狀態</label>
                                        <span class="text-success">
                                            <i class="fas fa-check-circle"></i> 正常
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <label>權限等級</label>
                                        <span>
                                            @if($user->isAdmin())
                                                <i class="fas fa-crown text-warning"></i> 管理員
                                            @else
                                                <i class="fas fa-user text-primary"></i> 一般用戶
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <label>密碼強度</label>
                                        <span class="text-info">
                                            <i class="fas fa-lock"></i> 已設定
                                        </span>
                                    </div>
                                </div>
                                <div class="info-card-footer">
                                    <a href="{{ route('user.edit-password') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-key"></i> 修改密碼
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="info-card">
                                <div class="info-card-header">
                                    <i class="fas fa-chart-line"></i>
                                    <h3>帳號統計</h3>
                                </div>
                                <div class="info-card-content">
                                    <div class="stats-table">
                                        <div class="stats-row">
                                            <div class="stats-label">
                                                <i class="fas fa-calendar-alt text-primary"></i>
                                                註冊天數
                                            </div>
                                            <div class="stats-value">{{ $user->created_at->diffInDays(now()) }}</div>
                                        </div>
                                        <div class="stats-row">
                                            <div class="stats-label">
                                                @if($user->isAdmin())
                                                    <i class="fas fa-crown text-warning"></i>
                                                    管理員權限
                                                @else
                                                    <i class="fas fa-user text-primary"></i>
                                                    一般用戶
                                                @endif
                                            </div>
                                            <div class="stats-value">
                                                @if($user->isAdmin())
                                                    是
                                                @else
                                                    否
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-card {
    background: var(--bg-secondary);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: all var(--transition-normal);
}

.info-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.info-card-header {
    background: var(--primary-color);
    color: var(--text-white);
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-card-header i {
    font-size: 1.25rem;
}

.info-card-header h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.info-card-content {
    padding: 1.5rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.info-item:last-child {
    border-bottom: none;
}

.info-item label {
    font-weight: 600;
    color: var(--text-secondary);
    margin: 0;
}

.info-item span {
    color: var(--text-primary);
    font-weight: 500;
}

.info-card-footer {
    padding: 1rem 1.5rem;
    background: var(--bg-primary);
    border-top: 1px solid var(--border-color);
}

.stat-item {
    text-align: center;
    padding: 1rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
}

.stat-label i {
    font-size: 0.8rem;
}

/* 表格式統計樣式 */
.stats-table {
    width: 100%;
}

.stats-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.stats-row:last-child {
    border-bottom: none;
}

.stats-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.95rem;
}

.stats-label i {
    font-size: 1rem;
    width: 1.2rem;
    text-align: center;
}

.stats-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary-color);
    text-align: right;
}

.card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.card-header {
    background: var(--bg-primary);
    border-bottom: 1px solid var(--border-color);
    padding: 1.5rem;
}

.card-header h2 {
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-body {
    padding: 2rem;
}

@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .info-card-content {
        padding: 1rem;
    }
    
    .info-card-footer {
        padding: 0.75rem 1rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .stats-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.75rem 0;
    }
    
    .stats-value {
        text-align: left;
        font-size: 1rem;
    }
}
</style>
@endsection
