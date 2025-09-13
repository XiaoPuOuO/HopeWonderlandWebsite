@extends('layouts.admin')

@section('page-title', '作品集詳情')

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">作品集詳情</h1>
        <p class="admin-description">{{ $portfolio->title }}</p>
    </div>
    <div class="admin-header-actions">
        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i>編輯
        </a>
        <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>返回列表
        </a>
    </div>
</div>

<div class="admin-content">
    <div class="admin-detail-grid">
        <!-- 主要資訊 -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">基本資訊</h3>
            </div>
            <div class="detail-card-content">
                <div class="detail-item">
                    <label class="detail-label">作品標題</label>
                    <p class="detail-value">{{ $portfolio->title }}</p>
                </div>
                
                <div class="detail-item">
                    <label class="detail-label">作品分類</label>
                    <p class="detail-value">
                        <span class="category-badge category-{{ $portfolio->category }}">
                            {{ $portfolio->category_display }}
                        </span>
                    </p>
                </div>
                
                <div class="detail-item">
                    <label class="detail-label">作品描述</label>
                    <p class="detail-value">{{ $portfolio->description }}</p>
                </div>
                
                @if($portfolio->content)
                <div class="detail-item">
                    <label class="detail-label">詳細內容</label>
                    <div class="detail-content">{{ $portfolio->content }}</div>
                </div>
                @endif
                
                <div class="detail-item">
                    <label class="detail-label">狀態</label>
                    <div class="detail-status">
                        <span class="status-badge {{ $portfolio->is_active ? 'status-active' : 'status-inactive' }}">
                            <i class="fas {{ $portfolio->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $portfolio->is_active ? '啟用' : '停用' }}
                        </span>
                        @if($portfolio->is_featured)
                            <span class="featured-badge">
                                <i class="fas fa-star"></i>精選作品
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 特色圖片 -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">特色圖片</h3>
            </div>
            <div class="detail-card-content">
                @if($portfolio->hasFeaturedImage())
                    <div class="detail-image">
                        <img src="{{ $portfolio->featured_image_url }}" alt="{{ $portfolio->title }}" class="detail-img">
                    </div>
                @else
                    <div class="detail-empty">
                        <i class="fas fa-image"></i>
                        <p>尚未上傳特色圖片</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="admin-detail-grid">
        <!-- 技術與連結 -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">技術與連結</h3>
            </div>
            <div class="detail-card-content">
                @if($portfolio->technologies && count($portfolio->technologies) > 0)
                <div class="detail-item">
                    <label class="detail-label">使用技術</label>
                    <div class="tech-tags">
                        @foreach($portfolio->technologies as $tech)
                            <span class="tech-tag">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($portfolio->project_url)
                <div class="detail-item">
                    <label class="detail-label">專案網址</label>
                    <p class="detail-value">
                        <a href="{{ $portfolio->project_url }}" target="_blank" class="detail-link">
                            <i class="fas fa-external-link-alt"></i>{{ $portfolio->project_url }}
                        </a>
                    </p>
                </div>
                @endif
                
                @if($portfolio->demo_url)
                <div class="detail-item">
                    <label class="detail-label">展示網址</label>
                    <p class="detail-value">
                        <a href="{{ $portfolio->demo_url }}" target="_blank" class="detail-link">
                            <i class="fas fa-play"></i>{{ $portfolio->demo_url }}
                        </a>
                    </p>
                </div>
                @endif
                
                @if($portfolio->github_url)
                <div class="detail-item">
                    <label class="detail-label">GitHub 網址</label>
                    <p class="detail-value">
                        <a href="{{ $portfolio->github_url }}" target="_blank" class="detail-link">
                            <i class="fab fa-github"></i>{{ $portfolio->github_url }}
                        </a>
                    </p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- 專案資訊 -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">專案資訊</h3>
            </div>
            <div class="detail-card-content">
                @if($portfolio->start_date)
                <div class="detail-item">
                    <label class="detail-label">開始日期</label>
                    <p class="detail-value">{{ $portfolio->start_date->format('Y年m月d日') }}</p>
                </div>
                @endif
                
                @if($portfolio->end_date)
                <div class="detail-item">
                    <label class="detail-label">結束日期</label>
                    <p class="detail-value">{{ $portfolio->end_date->format('Y年m月d日') }}</p>
                </div>
                @endif
                
                @if($portfolio->team_size)
                <div class="detail-item">
                    <label class="detail-label">團隊人數</label>
                    <p class="detail-value">{{ $portfolio->team_size }}人</p>
                </div>
                @endif
                
                @if($portfolio->duration_months)
                <div class="detail-item">
                    <label class="detail-label">開發時長</label>
                    <p class="detail-value">{{ $portfolio->duration_display }}</p>
                </div>
                @endif
                
                <div class="detail-item">
                    <label class="detail-label">排序順序</label>
                    <p class="detail-value">{{ $portfolio->sort_order }}</p>
                </div>
                
                <div class="detail-item">
                    <label class="detail-label">創建時間</label>
                    <p class="detail-value">{{ $portfolio->created_at->format('Y年m月d日 H:i') }}</p>
                </div>
                
                <div class="detail-item">
                    <label class="detail-label">最後更新</label>
                    <p class="detail-value">{{ $portfolio->updated_at->format('Y年m月d日 H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 操作按鈕 -->
    <div class="detail-actions">
        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-primary btn-large">
            <i class="fas fa-edit"></i>編輯作品集
        </a>
        <button class="btn btn-danger btn-large" onclick="deletePortfolio({{ $portfolio->id }}, {{ json_encode($portfolio->title) }})">
            <i class="fas fa-trash"></i>刪除作品集
        </button>
    </div>
</div>

<!-- 刪除表單 -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deletePortfolio(id, title) {
    showAlertModal({
        title: '確認刪除',
        message: `確定要刪除作品集「${title}」嗎？此操作無法復原。`,
        type: 'confirm',
        onConfirm: function() {
            const form = document.getElementById('delete-form');
            form.action = '/admin/portfolios/' + id;
            form.submit();
        }
    });
}
</script>
@endpush
