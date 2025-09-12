@extends('layouts.admin')


@section('page-title', '子品牌網站詳情')

@section('content')
<div class="admin-card">
    <!-- 品牌頭部 -->
    <div class="sub-brand-card-header" style="height: 12rem;">
        @if($subBrand->logo)
            <img src="{{ $subBrand->logo_url }}" alt="{{ $subBrand->name }}" class="sub-brand-logo" style="height: 6rem; width: 6rem;">
        @else
            <div class="sub-brand-icon">
                <i class="fas fa-star" style="font-size: 4rem;"></i>
            </div>
        @endif
    </div>
    
    <div class="sub-brand-content">
        <div class="admin-header-content" style="margin-bottom: 2rem;">
            <div>
                <h1 class="admin-page-title" style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $subBrand->name }}</h1>
                <p class="admin-page-description">{{ $subBrand->slug }}</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.sub-brands.edit', $subBrand) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>編輯
                </a>
                <a href="{{ route('admin.sub-brands.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>返回列表
                </a>
            </div>
        </div>
        
        <!-- 基本資訊 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">基本資訊</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">品牌名稱</label>
                        <p class="text-lg font-semibold">{{ $subBrand->name }}</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">URL 標識符</label>
                        <p class="text-lg font-mono">{{ $subBrand->slug }}</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">品牌描述</label>
                        <p class="text-lg">{{ $subBrand->description ?: '無描述' }}</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">官網連結</label>
                        @if($subBrand->website_url)
                            <a href="{{ $subBrand->website_url }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $subBrand->website_url }}
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        @else
                            <p class="text-light">未設定</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- 視覺資訊 -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">視覺資訊</h3>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">Logo</label>
                        @if($subBrand->logo)
                            <img src="{{ $subBrand->logo_url }}" alt="{{ $subBrand->name }}" 
                                 class="rounded-lg" style="height: 6rem; width: 6rem; object-fit: cover; margin-top: 0.5rem;">
                        @else
                            <div class="empty-icon" style="width: 6rem; height: 6rem; margin-top: 0.5rem;">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">品牌色彩</label>
                        <div class="btn-group" style="margin-top: 0.5rem;">
                            <div class="flex items-center" style="gap: 0.5rem;">
                                <div class="rounded-full border-2" 
                                     style="width: 2rem; height: 2rem; background-color: {{ $subBrand->color_primary }}; border-color: var(--border-color);"></div>
                                <span class="text-sm">{{ $subBrand->color_primary }}</span>
                            </div>
                            @if($subBrand->color_secondary)
                                <div class="flex items-center" style="gap: 0.5rem;">
                                    <div class="rounded-full border-2" 
                                         style="width: 2rem; height: 2rem; background-color: {{ $subBrand->color_secondary }}; border-color: var(--border-color);"></div>
                                    <span class="text-sm">{{ $subBrand->color_secondary }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 標籤 -->
        @if($subBrand->tags && count($subBrand->tags) > 0)
            <div class="admin-card mb-8">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">標籤</h3>
                </div>
                <div class="admin-card-body">
                    <div class="sub-brand-tags">
                        @foreach($subBrand->tags as $tag)
                            <span class="sub-brand-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        
        <!-- 狀態和設定 -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="admin-card">
                <div class="admin-card-body text-center">
                    <h4 class="font-semibold mb-2">狀態</h4>
                    <span class="btn {{ $subBrand->is_active ? 'btn-success' : 'btn-danger' }} btn-sm">
                        <i class="fas fa-circle"></i>
                        {{ $subBrand->is_active ? '啟用中' : '已停用' }}
                    </span>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="admin-card-body text-center">
                    <h4 class="font-semibold mb-2">排序順序</h4>
                    <p class="text-2xl font-bold">{{ $subBrand->sort_order }}</p>
                </div>
            </div>
            
            <div class="admin-card">
                <div class="admin-card-body text-center">
                    <h4 class="font-semibold mb-2">創建時間</h4>
                    <p class="text-lg">{{ $subBrand->created_at->format('Y年m月d日 H:i') }}</p>
                </div>
            </div>
        </div>
        
        <!-- 操作按鈕 -->
        <div class="admin-card">
            <div class="admin-card-footer">
                <div class="btn-group" style="justify-content: flex-end;">
                    <button type="button" 
                            class="btn btn-danger"
                            onclick="confirmDeleteSubBrand({{ $subBrand->id }}, '{{ $subBrand->name }}')">
                        <i class="fas fa-trash"></i>刪除
                    </button>
                    <a href="{{ route('admin.sub-brands.edit', $subBrand) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i>編輯
                    </a>
                </div>
            </div>
        </div>
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
            // 創建隱藏的表單來提交刪除請求
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/sub-brands/${id}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection