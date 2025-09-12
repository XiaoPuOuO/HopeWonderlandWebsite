@extends('layouts.admin')

@section('page-title', '作品集管理')


@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">作品集管理</h1>
        <p class="admin-description">管理您的作品集項目</p>
    </div>
    <div class="admin-header-actions">
        <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>新增作品集
        </a>
    </div>
</div>

<div class="admin-content">
    @if(session('success'))
        <div class="admin-notification admin-notification-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($portfolios->count() > 0)
        <div class="admin-grid">
            @foreach($portfolios as $portfolio)
                <div class="admin-card portfolio-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card-header">
                        <div class="card-image">
                            @if($portfolio->hasFeaturedImage())
                                <img src="{{ $portfolio->featured_image_url }}" alt="{{ $portfolio->title }}" class="card-img">
                            @else
                                <div class="card-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-badges">
                            <span class="status-badge {{ $portfolio->is_active ? 'status-active' : 'status-inactive' }}" 
                                  onclick="togglePortfolioStatus({{ $portfolio->id }}, '{{ $portfolio->is_active ? 'false' : 'true' }}')">
                                <i class="fas {{ $portfolio->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $portfolio->is_active ? '啟用' : '停用' }}
                            </span>
                            @if($portfolio->is_featured)
                                <span class="featured-badge" onclick="togglePortfolioFeatured({{ $portfolio->id }}, 'false')">
                                    <i class="fas fa-star"></i>精選
                                </span>
                            @else
                                <span class="featured-badge featured-inactive" onclick="togglePortfolioFeatured({{ $portfolio->id }}, 'true')">
                                    <i class="far fa-star"></i>設為精選
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title">{{ $portfolio->title }}</h3>
                        <p class="card-description">{{ Str::limit($portfolio->description, 100) }}</p>
                        
                        <div class="card-meta">
                            <span class="meta-item">
                                <i class="fas fa-tag"></i>{{ $portfolio->category_display }}
                            </span>
                            @if($portfolio->start_date)
                                <span class="meta-item">
                                    <i class="fas fa-calendar"></i>{{ $portfolio->start_date->format('Y年') }}
                                </span>
                            @endif
                            @if($portfolio->technologies && count($portfolio->technologies) > 0)
                                <span class="meta-item">
                                    <i class="fas fa-code"></i>{{ count($portfolio->technologies) }}項技術
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <a href="{{ route('admin.portfolios.show', $portfolio) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>查看
                        </a>
                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>編輯
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="deletePortfolio({{ $portfolio->id }}, '{{ $portfolio->title }}')">
                            <i class="fas fa-trash"></i>刪除
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="admin-pagination">
            {{ $portfolios->links() }}
        </div>
    @else
        <div class="admin-empty">
            <div class="empty-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <h3 class="empty-title">尚未有作品集</h3>
            <p class="empty-description">開始創建您的第一個作品集項目</p>
        </div>
    @endif
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
            form.action = `/admin/portfolios/${id}`;
            form.submit();
        }
    });
}

function togglePortfolioStatus(id, newStatus) {
    const statusText = newStatus === 'true' ? '啟用' : '停用';
    
    showAlertModal({
        title: '確認狀態切換',
        message: `確定要${statusText}此作品集嗎？`,
        type: 'confirm',
        onConfirm: function() {
            fetch(`/admin/portfolios/${id}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    is_active: newStatus === 'true'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('操作失敗，請稍後再試', 'error');
            });
        }
    });
}

function togglePortfolioFeatured(id, newStatus) {
    const statusText = newStatus === 'true' ? '設為精選' : '取消精選';
    
    showAlertModal({
        title: '確認精選狀態切換',
        message: `確定要${statusText}此作品集嗎？`,
        type: 'confirm',
        onConfirm: function() {
            fetch(`/admin/portfolios/${id}/toggle-featured`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    is_featured: newStatus === 'true'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('操作失敗，請稍後再試', 'error');
            });
        }
    });
}
</script>
@endpush
