@extends('layouts.admin')

@section('page-title', '子品牌網站管理')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-header-content">
            <div>
                <h3 class="admin-card-title">子品牌網站列表</h3>
                <p class="admin-page-description">管理 HopeWonderland Studio 的所有子品牌網站</p>
            </div>
            <a href="{{ route('admin.sub-brands.create') }}" 
               class="btn btn-primary">
                <i class="fas fa-plus"></i>新增子品牌網站
            </a>
        </div>
    </div>

    <div class="admin-card-body">
        @if($subBrands->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($subBrands as $subBrand)
                    <div class="sub-brand-card" data-sub-brand-id="{{ $subBrand->id }}">
                        <div class="sub-brand-card-header">
                            @if($subBrand->logo)
                                <img src="{{ $subBrand->logo_url }}" alt="{{ $subBrand->name }}" class="sub-brand-logo">
                            @else
                                <div class="sub-brand-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                            @endif
                        </div>
                        <div class="sub-brand-content">
                            <div class="sub-brand-header">
                                <h4 class="sub-brand-name">{{ $subBrand->name }}</h4>
                                <span class="status-badge {{ $subBrand->is_active ? 'status-active' : 'status-inactive' }}" 
                                      onclick="toggleSubBrandStatus({{ $subBrand->id }}, '{{ $subBrand->is_active ? 'false' : 'true' }}')">
                                    <i class="fas {{ $subBrand->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $subBrand->is_active ? '啟用' : '停用' }}
                                </span>
                            </div>
                            <p class="sub-brand-description">{{ $subBrand->description ?: '無描述' }}</p>
                            
                            @if($subBrand->tags && count($subBrand->tags) > 0)
                                <div class="sub-brand-tags">
                                    @foreach($subBrand->tags as $tag)
                                        <span class="sub-brand-tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="sub-brand-actions">
                                <div class="btn-group">
                                    <a href="{{ route('admin.sub-brands.show', $subBrand) }}" 
                                       class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.sub-brands.edit', $subBrand) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger"
                                            onclick="confirmDeleteSubBrand({{ $subBrand->id }}, {{ json_encode($subBrand->name) }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="empty-title">尚無子品牌網站</h3>
                <p class="empty-description">開始建立您的第一個子品牌網站</p>
                <a href="{{ route('admin.sub-brands.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>新增子品牌網站
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function confirmDeleteSubBrand(id, name) {
    showAlertModal({
        title: '確認刪除',
        message: `確定要刪除子品牌「${name}」嗎？此操作無法復原。`,
        type: 'confirm',
        onConfirm: function() {
            // 使用 AJAX 刪除
            deleteSubBrand(id, name);
        },
        onCancel: function() {
            showNotification('操作已取消', 'info');
        }
    });
}

function deleteSubBrand(id, name) {
    // 找到對應的卡片元素
    const cardElement = document.querySelector('[data-sub-brand-id="' + id + '"]');
    
    // 發送 AJAX 刪除請求
    fetch('/admin/sub-brands/' + id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('刪除失敗');
    })
    .then(data => {
        // 顯示成功通知
        showNotification(`子品牌「${name}」已成功刪除`, 'success');
        
        // 播放 FadeOut 動畫並移除卡片
        if (cardElement) {
            cardElement.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
            cardElement.style.opacity = '0';
            cardElement.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                cardElement.remove();
                
                // 檢查是否還有其他卡片，如果沒有則顯示空狀態
                const remainingCards = document.querySelectorAll('.sub-brand-card');
                if (remainingCards.length === 0) {
                    showEmptyState();
                }
            }, 500);
        }
    })
    .catch(error => {
        console.error('刪除錯誤:', error);
        showNotification('刪除失敗，請稍後再試', 'error');
    });
}

function showEmptyState() {
    const container = document.querySelector('.grid');
    if (container) {
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="empty-title">尚無子品牌網站</h3>
                <p class="empty-description">開始建立您的第一個子品牌網站</p>
                <a href="{{ route('admin.sub-brands.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>新增子品牌網站
                </a>
            </div>
        `;
    }
}

// 切換子品牌狀態
function toggleSubBrandStatus(id, newStatus) {
    const statusBadge = document.querySelector(`[data-sub-brand-id="${id}"] .status-badge`);
    const isActive = newStatus === 'true';
    
    console.log('調試信息:', {
        id: id,
        newStatus: newStatus,
        newStatusType: typeof newStatus,
        isActive: isActive,
        currentBadgeText: statusBadge.textContent.trim()
    });
    
    // 顯示確認對話框
    showAlertModal({
        title: '確認狀態變更',
        message: `確定要將此子品牌${isActive ? '啟用' : '停用'}嗎？`,
        type: 'confirm',
        onConfirm: function() {
            updateSubBrandStatus(id, isActive, statusBadge);
        },
        onCancel: function() {
            showNotification('操作已取消', 'info');
        }
    });
}

function updateSubBrandStatus(id, isActive, statusBadge) {
    // 發送 AJAX 請求更新狀態
    fetch(`/admin/sub-brands/${id}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            is_active: isActive
        })
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('狀態更新失敗');
    })
    .then(data => {
        // 更新狀態徽章
        if (isActive) {
            statusBadge.className = 'status-badge status-active';
            statusBadge.innerHTML = '<i class="fas fa-check-circle"></i>啟用';
        } else {
            statusBadge.className = 'status-badge status-inactive';
            statusBadge.innerHTML = '<i class="fas fa-times-circle"></i>停用';
        }
        
        // 更新點擊事件
        statusBadge.setAttribute('onclick', `toggleSubBrandStatus(${id}, ${!isActive})`);
        
        // 顯示成功通知
        showNotification(data.message, 'success');
    })
    .catch(error => {
        console.error('狀態更新錯誤:', error);
        showNotification('狀態更新失敗，請稍後再試', 'error');
    });
}
</script>
@endpush
@endsection
