@extends('layouts.admin')

@section('page-title', '團隊成員詳情')
@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">團隊成員詳情</h1>
        <p class="admin-description">{{ $teamMember->name }}</p>
    </div>
    <div class="admin-header-actions">
        <a href="{{ route('admin.team-members.edit', $teamMember) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i>編輯
        </a>
        <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary">
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
                    <label class="detail-label">姓名</label>
                    <p class="detail-value">{{ $teamMember->name }}</p>
                </div>
                
                <div class="detail-item">
                    <label class="detail-label">職位</label>
                    <p class="detail-value">{{ $teamMember->position }}</p>
                </div>
                
                @if($teamMember->email)
                <div class="detail-item">
                    <label class="detail-label">電子郵件</label>
                    <p class="detail-value">
                        <a href="mailto:{{ $teamMember->email }}" class="detail-link">
                            <i class="fas fa-envelope"></i>{{ $teamMember->email }}
                        </a>
                    </p>
                </div>
                @endif
                
                @if($teamMember->bio)
                <div class="detail-item">
                    <label class="detail-label">個人簡介</label>
                    <div class="detail-content">{{ $teamMember->bio }}</div>
                </div>
                @endif
                
                <div class="detail-item">
                    <label class="detail-label">狀態</label>
                    <div class="detail-status">
                        <span class="status-badge {{ $teamMember->is_active ? 'status-active' : 'status-inactive' }}">
                            <i class="fas {{ $teamMember->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $teamMember->is_active ? '啟用' : '停用' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 頭像 -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">頭像</h3>
            </div>
            <div class="detail-card-content">
                @if($teamMember->hasAvatar())
                    <div class="detail-image">
                        <img src="{{ $teamMember->avatar_url }}" alt="{{ $teamMember->name }}" class="detail-img">
                    </div>
                @else
                    <div class="detail-empty">
                        <i class="fas fa-user-circle"></i>
                        <p>尚未上傳頭像</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="admin-detail-grid">
        <!-- 技能專長 -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">技能專長</h3>
            </div>
            <div class="detail-card-content">
                @if($teamMember->skills && count($teamMember->skills) > 0)
                    <div class="tech-tags">
                        @foreach($teamMember->skills as $skill)
                            <span class="tech-tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                @else
                    <div class="detail-empty">
                        <i class="fas fa-code"></i>
                        <p>尚未添加技能</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- 社群連結 -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">社群連結</h3>
            </div>
            <div class="detail-card-content">
                @if($teamMember->social_links)
                    @if(isset($teamMember->social_links['linkedin']))
                    <div class="detail-item">
                        <label class="detail-label">LinkedIn</label>
                        <p class="detail-value">
                            <a href="{{ $teamMember->social_links['linkedin'] }}" target="_blank" class="detail-link">
                                <i class="fab fa-linkedin"></i>{{ $teamMember->social_links['linkedin'] }}
                            </a>
                        </p>
                    </div>
                    @endif
                    
                    @if(isset($teamMember->social_links['github']))
                    <div class="detail-item">
                        <label class="detail-label">GitHub</label>
                        <p class="detail-value">
                            <a href="{{ $teamMember->social_links['github'] }}" target="_blank" class="detail-link">
                                <i class="fab fa-github"></i>{{ $teamMember->social_links['github'] }}
                            </a>
                        </p>
                    </div>
                    @endif
                    
                    @if(isset($teamMember->social_links['twitter']))
                    <div class="detail-item">
                        <label class="detail-label">Twitter</label>
                        <p class="detail-value">
                            <a href="{{ $teamMember->social_links['twitter'] }}" target="_blank" class="detail-link">
                                <i class="fab fa-twitter"></i>{{ $teamMember->social_links['twitter'] }}
                            </a>
                        </p>
                    </div>
                    @endif
                    
                    @if(isset($teamMember->social_links['website']))
                    <div class="detail-item">
                        <label class="detail-label">個人網站</label>
                        <p class="detail-value">
                            <a href="{{ $teamMember->social_links['website'] }}" target="_blank" class="detail-link">
                                <i class="fas fa-globe"></i>{{ $teamMember->social_links['website'] }}
                            </a>
                        </p>
                    </div>
                    @endif
                @endif
                
                @if(!$teamMember->social_links || (empty($teamMember->social_links['linkedin']) && empty($teamMember->social_links['github']) && empty($teamMember->social_links['twitter']) && empty($teamMember->social_links['website'])))
                    <div class="detail-empty">
                        <i class="fas fa-share-alt"></i>
                        <p>尚未添加社群連結</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- 其他資訊 -->
    <div class="detail-card">
        <div class="detail-card-header">
            <h3 class="detail-card-title">其他資訊</h3>
        </div>
        <div class="detail-card-content">
            <div class="detail-row">
                <div class="detail-item">
                    <label class="detail-label">排序順序</label>
                    <p class="detail-value">{{ $teamMember->sort_order }}</p>
                </div>
                
                <div class="detail-item">
                    <label class="detail-label">創建時間</label>
                    <p class="detail-value">{{ $teamMember->created_at->format('Y年m月d日 H:i') }}</p>
                </div>
                
                <div class="detail-item">
                    <label class="detail-label">最後更新</label>
                    <p class="detail-value">{{ $teamMember->updated_at->format('Y年m月d日 H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 操作按鈕 -->
    <div class="detail-actions">
        <a href="{{ route('admin.team-members.edit', $teamMember) }}" class="btn btn-primary btn-large">
            <i class="fas fa-edit"></i>編輯成員
        </a>
        <button class="btn btn-danger btn-large" onclick="deleteTeamMember({{ $teamMember->id }}, '{{ $teamMember->name }}')">
            <i class="fas fa-trash"></i>刪除成員
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
function deleteTeamMember(id, name) {
    showAlertModal({
        title: '確認刪除',
        message: `確定要刪除團隊成員「${name}」嗎？此操作無法復原。`,
        type: 'confirm',
        onConfirm: function() {
            const form = document.getElementById('delete-form');
            form.action = `/admin/team-members/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush
