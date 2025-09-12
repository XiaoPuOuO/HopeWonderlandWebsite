@extends('layouts.admin')

@section('page-title', '編輯子品牌網站')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-header-content">
            <div>
                <h3 class="admin-card-title">編輯子品牌網站：{{ $subBrand->name }}</h3>
                <p class="admin-page-description">修改子品牌網站的基本資訊</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.sub-brands.show', $subBrand) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i>查看詳情
                </a>
                <a href="{{ route('admin.sub-brands.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>返回列表
                </a>
            </div>
        </div>
    </div>
    
    <div class="admin-card-body">
        <form id="subBrandForm" action="{{ route('admin.sub-brands.update', $subBrand) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- 基本資訊 -->
            <div class="admin-card mb-6">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">基本資訊</h4>
                </div>
                <div class="admin-card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                品牌名稱 <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $subBrand->name) }}"
                                   required
                                   class="form-control @error('name') border-danger @enderror">
                            @error('name')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="slug" class="form-label">URL 標識符</label>
                            <input type="text" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $subBrand->slug) }}"
                                   placeholder="留空將自動生成"
                                   class="form-control @error('slug') border-danger @enderror">
                            @error('slug')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">品牌描述</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="form-control @error('description') border-danger @enderror">{{ old('description', $subBrand->description) }}</textarea>
                        @error('description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Logo 管理 -->
            <div class="admin-card mb-6">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">Logo 管理</h4>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">品牌 Logo</label>
                        <div id="logo-preview-container">
                            @if($subBrand->logo)
                                <div class="logo-preview">
                                    <img src="{{ $subBrand->logo_url }}" alt="{{ $subBrand->name }}" 
                                         class="logo-image" id="logo-preview"
                                         onload="console.log('Logo 載入成功:', this.src)"
                                         onerror="console.error('Logo 載入失敗:', this.src)">
                                    <div class="logo-actions">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="changeLogo()">
                                            <i class="fas fa-edit"></i>更換
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeLogo()">
                                            <i class="fas fa-trash"></i>刪除
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="logo-upload">
                                    <button type="button" class="btn btn-primary" onclick="uploadLogo()">
                                        <i class="fas fa-upload"></i>上傳 Logo
                                    </button>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" id="logo" name="logo" value="{{ old('logo', $subBrand->logo) }}">
                        @error('logo')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- 連結資訊 -->
            <div class="admin-card mb-6">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">連結資訊</h4>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label for="website_url" class="form-label">官網連結</label>
                        <input type="url" 
                               id="website_url" 
                               name="website_url" 
                               value="{{ old('website_url', $subBrand->website_url) }}"
                               placeholder="https://example.com"
                               class="form-control @error('website_url') border-danger @enderror">
                        @error('website_url')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- 排序設定 -->
            <div class="admin-card mb-6">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">排序設定</h4>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label for="sort_order" class="form-label">排序順序</label>
                        <input type="number" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $subBrand->sort_order) }}"
                               min="0"
                               class="form-control @error('sort_order') border-danger @enderror">
                        @error('sort_order')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- 標籤管理 -->
            <div class="admin-card mb-6">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">標籤管理</h4>
                </div>
                <div class="admin-card-body">
                    <div id="tags-container" class="space-y-3">
                        @if($subBrand->tags && count($subBrand->tags) > 0)
                            @foreach($subBrand->tags as $index => $tag)
                                <div class="btn-group">
                                    <input type="text" 
                                           name="tags[]" 
                                           value="{{ $tag }}"
                                           placeholder="輸入標籤"
                                           class="form-control">
                                    @if($index > 0)
                                        <button type="button" 
                                                onclick="removeTag(this)" 
                                                class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <button type="button" 
                                                onclick="addTag()" 
                                                class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="btn-group">
                                <input type="text" 
                                       name="tags[]" 
                                       placeholder="輸入標籤"
                                       class="form-control">
                                <button type="button" 
                                        onclick="addTag()" 
                                        class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="form-text">按 + 按鈕添加更多標籤</div>
                </div>
            </div>
            
            <!-- 狀態設定 -->
            <div class="admin-card mb-6">
                <div class="admin-card-header">
                    <h4 class="admin-card-title">狀態設定</h4>
                </div>
                <div class="admin-card-body">
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $subBrand->is_active) ? 'checked' : '' }}
                                   class="form-control" style="width: auto; margin-right: 0.5rem;">
                            啟用此子品牌
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- 操作按鈕 -->
            <div class="admin-card">
                <div class="admin-card-footer">
                    <div class="btn-group" style="justify-content: flex-end;">
                        <a href="{{ route('admin.sub-brands.index') }}" class="btn btn-secondary">
                            取消
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>更新
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Logo 管理功能
function uploadLogo() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            uploadLogoToServer(file);
        }
    };
    input.click();
}

function uploadLogoToServer(file) {
    const formData = new FormData();
    formData.append('logo', file);
    
    // 顯示上傳中狀態
    const container = document.getElementById('logo-preview-container');
    container.innerHTML = `
        <div class="logo-upload">
            <div class="upload-progress">
                <i class="fas fa-spinner fa-spin"></i>
                <span>上傳中...</span>
            </div>
        </div>
    `;
    
    fetch('{{ route("admin.sub-brands.upload-logo") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('上傳成功，URL:', data.data.url);
            console.log('路徑:', data.data.path);
            updateLogoPreview(data.data.url);
            document.getElementById('logo').value = data.data.path;
            showNotification(data.message, 'success');
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        console.error('上傳錯誤:', error);
        showNotification('Logo 上傳失敗：' + error.message, 'error');
        // 恢復原來的預覽
        @if($subBrand->logo)
            updateLogoPreview('{{ $subBrand->logo_url }}');
        @else
            container.innerHTML = `
                <div class="logo-upload">
                    <button type="button" class="btn btn-primary" onclick="uploadLogo()">
                        <i class="fas fa-upload"></i>上傳 Logo
                    </button>
                </div>
            `;
        @endif
    });
}

function changeLogo() {
    uploadLogo();
}

function removeLogo() {
    showAlertModal({
        title: '確認刪除 Logo',
        message: '確定要刪除這個 Logo 嗎？此操作無法復原。',
        type: 'confirm',
        onConfirm: function() {
            deleteLogoFromServer();
        },
        onCancel: function() {
            showNotification('已取消刪除', 'info');
        }
    });
}

function deleteLogoFromServer() {
    fetch('{{ route("admin.sub-brands.delete-logo", $subBrand) }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 設置特殊標記表示要刪除 Logo
            document.getElementById('logo').value = '__DELETE__';
            document.getElementById('logo-preview-container').innerHTML = `
                <div class="logo-upload">
                    <button type="button" class="btn btn-primary" onclick="uploadLogo()">
                        <i class="fas fa-upload"></i>上傳 Logo
                    </button>
                </div>
            `;
            showNotification(data.message, 'success');
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        console.error('刪除錯誤:', error);
        showNotification('Logo 刪除失敗：' + error.message, 'error');
    });
}

function updateLogoPreview(logoUrl) {
    console.log('更新預覽，URL:', logoUrl);
    document.getElementById('logo-preview-container').innerHTML = `
        <div class="logo-preview">
            <img src="${logoUrl}" 
                 alt="Logo 預覽" 
                 class="logo-image" 
                 id="logo-preview"
                 onload="console.log('圖片載入成功')"
                 onerror="console.error('圖片載入失敗:', this.src); this.style.display='none'; this.nextElementSibling.style.display='block';">
            <div style="display:none; padding: 1rem; text-align: center; color: var(--error-color);">
                <i class="fas fa-exclamation-triangle"></i>
                <p>圖片載入失敗</p>
                <small>URL: ${logoUrl}</small>
            </div>
            <div class="logo-actions">
                <button type="button" class="btn btn-primary btn-sm" onclick="changeLogo()">
                    <i class="fas fa-edit"></i>更換
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeLogo()">
                    <i class="fas fa-trash"></i>刪除
                </button>
            </div>
        </div>
    `;
}

// 添加標籤
function addTag() {
    const container = document.getElementById('tags-container');
    const newTag = document.createElement('div');
    newTag.className = 'btn-group';
    newTag.innerHTML = `
        <input type="text" 
               name="tags[]" 
               placeholder="輸入標籤"
               class="form-control">
        <button type="button" 
                onclick="removeTag(this)" 
                class="btn btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newTag);
}

// 移除標籤
function removeTag(button) {
    button.parentElement.remove();
}
</script>
@endpush
@endsection