@extends('layouts.admin')

@section('page-title', '新增作品集')

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">新增作品集</h1>
        <p class="admin-description">創建新的作品集項目</p>
    </div>
    <div class="admin-header-actions">
        <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>返回列表
        </a>
    </div>
</div>

<div class="admin-content">
    <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        
        <div class="form-grid">
            <!-- 基本資訊 -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">基本資訊</h3>
                </div>
                <div class="form-card-content">
                    <div class="form-group">
                        <label for="title" class="form-label">作品標題 <span class="required">*</span></label>
                        <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">作品描述 <span class="required">*</span></label>
                        <textarea id="description" name="description" class="form-textarea" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="category" class="form-label">作品分類 <span class="required">*</span></label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">請選擇分類</option>
                            <option value="game" {{ old('category') == 'game' ? 'selected' : '' }}>遊戲開發</option>
                            <option value="saas" {{ old('category') == 'saas' ? 'selected' : '' }}>SaaS 平台</option>
                            <option value="web" {{ old('category') == 'web' ? 'selected' : '' }}>網站開發</option>
                            <option value="mobile" {{ old('category') == 'mobile' ? 'selected' : '' }}>行動應用</option>
                        </select>
                        @error('category')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="content" class="form-label">詳細內容</label>
                        <textarea id="content" name="content" class="form-textarea" rows="6">{{ old('content') }}</textarea>
                        @error('content')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- 特色圖片 -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">特色圖片</h3>
                </div>
                <div class="form-card-content">
                    <div class="image-upload-area" id="image-upload-area">
                        <div class="image-preview" id="image-preview" style="display: none;">
                            <img id="preview-img" src="" alt="預覽圖片">
                            <div class="image-actions">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                                    <i class="fas fa-trash"></i>刪除
                                </button>
                            </div>
                        </div>
                        <div class="image-upload-placeholder" id="image-upload-placeholder">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>點擊上傳圖片</p>
                            <input type="file" id="featured_image" name="featured_image" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    @error('featured_image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-grid">
            <!-- 技術與連結 -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">技術與連結</h3>
                </div>
                <div class="form-card-content">
                    <div class="form-group">
                        <label for="technologies" class="form-label">使用技術</label>
                        <div class="tag-input-container">
                            <input type="text" id="tech-input" class="form-input" placeholder="輸入技術名稱後按 Enter">
                            <div class="tag-list" id="tech-tags">
                                @if(old('technologies'))
                                    @foreach(old('technologies') as $tech)
                                        <span class="tag-item">
                                            {{ $tech }}
                                            <input type="hidden" name="technologies[]" value="{{ $tech }}">
                                            <button type="button" class="tag-remove" onclick="removeTag(this)">×</button>
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="project_url" class="form-label">專案網址</label>
                        <input type="url" id="project_url" name="project_url" class="form-input" value="{{ old('project_url') }}" placeholder="https://example.com">
                        @error('project_url')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="demo_url" class="form-label">展示網址</label>
                        <input type="url" id="demo_url" name="demo_url" class="form-input" value="{{ old('demo_url') }}" placeholder="https://demo.example.com">
                        @error('demo_url')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="github_url" class="form-label">GitHub 網址</label>
                        <input type="url" id="github_url" name="github_url" class="form-input" value="{{ old('github_url') }}" placeholder="https://github.com/username/repo">
                        @error('github_url')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- 專案資訊 -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">專案資訊</h3>
                </div>
                <div class="form-card-content">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="start_date" class="form-label">開始日期</label>
                            <input type="date" id="start_date" name="start_date" class="form-input" value="{{ old('start_date') }}">
                            @error('start_date')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="end_date" class="form-label">結束日期</label>
                            <input type="date" id="end_date" name="end_date" class="form-input" value="{{ old('end_date') }}">
                            @error('end_date')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="team_size" class="form-label">團隊人數</label>
                            <input type="number" id="team_size" name="team_size" class="form-input" value="{{ old('team_size') }}" min="1">
                            @error('team_size')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="duration_months" class="form-label">開發時長（月）</label>
                            <input type="number" id="duration_months" name="duration_months" class="form-input" value="{{ old('duration_months') }}" min="1">
                            @error('duration_months')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="sort_order" class="form-label">排序順序</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-input" value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 狀態設定 -->
        <div class="form-card">
            <div class="form-card-header">
                <h3 class="form-card-title">狀態設定</h3>
            </div>
            <div class="form-card-content">
                <div class="form-checkboxes">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <span class="checkbox-label">設為精選作品</span>
                    </label>
                    
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="checkbox-label">啟用顯示</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">
                <i class="fas fa-save"></i>創建作品集
            </button>
            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary btn-large">
                <i class="fas fa-times"></i>取消
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 圖片上傳處理
    const uploadArea = document.getElementById('image-upload-area');
    const fileInput = document.getElementById('featured_image');
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const placeholder = document.getElementById('image-upload-placeholder');
    
    uploadArea.addEventListener('click', () => fileInput.click());
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
    
    // 技術標籤處理
    const techInput = document.getElementById('tech-input');
    const techTags = document.getElementById('tech-tags');
    
    techInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = this.value.trim();
            if (value && !Array.from(techTags.children).some(tag => tag.textContent.trim() === value)) {
                addTechTag(value);
                this.value = '';
            }
        }
    });
});

function removeImage() {
    document.getElementById('featured_image').value = '';
    document.getElementById('image-preview').style.display = 'none';
    document.getElementById('image-upload-placeholder').style.display = 'block';
}

function addTechTag(value) {
    const tagContainer = document.getElementById('tech-tags');
    const tag = document.createElement('span');
    tag.className = 'tag-item';
    tag.innerHTML = `
        ${value}
        <input type="hidden" name="technologies[]" value="${value}">
        <button type="button" class="tag-remove" onclick="removeTag(this)">×</button>
    `;
    tagContainer.appendChild(tag);
}

function removeTag(button) {
    button.parentElement.remove();
}
</script>
@endpush
