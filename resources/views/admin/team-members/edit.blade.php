@extends('layouts.admin')

@section('page-title', '編輯團隊成員')

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">編輯團隊成員</h1>
        <p class="admin-description">修改成員「{{ $teamMember->name }}」的資料</p>
    </div>
    <div class="admin-header-actions">
        <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>返回列表
        </a>
    </div>
</div>

<div class="admin-content">
    <form action="{{ route('admin.team-members.update', $teamMember) }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <!-- 基本資訊 -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">基本資訊</h3>
                </div>
                <div class="form-card-content">
                    <div class="form-group">
                        <label for="name" class="form-label">姓名 <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $teamMember->name) }}" required>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="position" class="form-label">職位 <span class="required">*</span></label>
                        <input type="text" id="position" name="position" class="form-input" value="{{ old('position', $teamMember->position) }}" required>
                        @error('position')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">電子郵件</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $teamMember->email) }}">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="bio" class="form-label">個人簡介</label>
                        <textarea id="bio" name="bio" class="form-textarea" rows="4">{{ old('bio', $teamMember->bio) }}</textarea>
                        @error('bio')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="sort_order" class="form-label">排序順序</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-input" value="{{ old('sort_order', $teamMember->sort_order) }}" min="0">
                        @error('sort_order')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- 頭像 -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">頭像</h3>
                </div>
                <div class="form-card-content">
                    <div class="image-upload-area" id="image-upload-area">
                        <div class="image-preview" id="image-preview" style="{{ $teamMember->hasAvatar() ? 'display: block;' : 'display: none;' }}">
                            <img id="preview-img" src="{{ $teamMember->hasAvatar() ? $teamMember->avatar_url : '' }}" alt="預覽頭像">
                            <div class="image-actions">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                                    <i class="fas fa-trash"></i>刪除
                                </button>
                            </div>
                        </div>
                        <div class="image-upload-placeholder" id="image-upload-placeholder" style="{{ $teamMember->hasAvatar() ? 'display: none;' : 'display: block;' }}">
                            <i class="fas fa-user-circle"></i>
                            <p>點擊上傳頭像</p>
                            <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                        </div>
                    </div>
                    @error('avatar')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-grid">
            <!-- 技能 -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">技能專長</h3>
                </div>
                <div class="form-card-content">
                    <div class="form-group">
                        <label for="skills" class="form-label">技能標籤</label>
                        <div class="tag-input-container">
                            <input type="text" id="skill-input" class="form-input" placeholder="輸入技能名稱後按 Enter">
                            <div class="tag-list" id="skill-tags">
                                @foreach(old('skills', $teamMember->skills ?? []) as $skill)
                                    <span class="tag-item">
                                        {{ $skill }}
                                        <input type="hidden" name="skills[]" value="{{ $skill }}">
                                        <button type="button" class="tag-remove" onclick="removeTag(this)">×</button>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 社群連結 -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">社群連結</h3>
                </div>
                <div class="form-card-content">
                    <div class="form-group">
                        <label for="social_links_linkedin" class="form-label">LinkedIn</label>
                        <input type="url" id="social_links_linkedin" name="social_links[linkedin]" class="form-input" value="{{ old('social_links.linkedin', $teamMember->social_links['linkedin'] ?? '') }}" placeholder="https://linkedin.com/in/username">
                        @error('social_links.linkedin')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="social_links_github" class="form-label">GitHub</label>
                        <input type="url" id="social_links_github" name="social_links[github]" class="form-input" value="{{ old('social_links.github', $teamMember->social_links['github'] ?? '') }}" placeholder="https://github.com/username">
                        @error('social_links.github')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="social_links_twitter" class="form-label">Twitter</label>
                        <input type="url" id="social_links_twitter" name="social_links[twitter]" class="form-input" value="{{ old('social_links.twitter', $teamMember->social_links['twitter'] ?? '') }}" placeholder="https://twitter.com/username">
                        @error('social_links.twitter')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="social_links_website" class="form-label">個人網站</label>
                        <input type="url" id="social_links_website" name="social_links[website]" class="form-input" value="{{ old('social_links.website', $teamMember->social_links['website'] ?? '') }}" placeholder="https://yourwebsite.com">
                        @error('social_links.website')
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
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $teamMember->is_active) ? 'checked' : '' }}>
                        <span class="checkbox-label">啟用顯示</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">
                <i class="fas fa-save"></i>更新成員
            </button>
            <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary btn-large">
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
    const fileInput = document.getElementById('avatar');
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
    
    // 技能標籤處理
    const skillInput = document.getElementById('skill-input');
    const skillTags = document.getElementById('skill-tags');
    
    skillInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = this.value.trim();
            if (value && !Array.from(skillTags.children).some(tag => tag.textContent.trim() === value)) {
                addSkillTag(value);
                this.value = '';
            }
        }
    });
});

function removeImage() {
    document.getElementById('avatar').value = '';
    document.getElementById('image-preview').style.display = 'none';
    document.getElementById('image-upload-placeholder').style.display = 'block';
}

function addSkillTag(value) {
    const tagContainer = document.getElementById('skill-tags');
    const tag = document.createElement('span');
    tag.className = 'tag-item';
    tag.innerHTML = 
        value +
        '<input type="hidden" name="skills[]" value="' + value + '">' +
        '<button type="button" class="tag-remove" onclick="removeTag(this)">×</button>';
    tagContainer.appendChild(tag);
}

function removeTag(button) {
    button.parentElement.remove();
}
</script>
@endpush
