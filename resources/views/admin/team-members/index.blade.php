@extends('layouts.admin')


@section('page-title', '團隊成員管理')

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">團隊成員管理</h1>
        <p class="admin-description">管理您的核心團隊成員</p>
    </div>
    <div class="admin-header-actions">
        <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>新增成員
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

    @if($teamMembers->count() > 0)
        <div class="admin-grid">
            @foreach($teamMembers as $member)
                <div class="admin-card team-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card-header">
                        <div class="card-image">
                            @if($member->hasAvatar())
                                <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="card-img">
                            @else
                                <div class="card-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-badges">
                            <span class="status-badge {{ $member->is_active ? 'status-active' : 'status-inactive' }}" 
                                  onclick="toggleTeamMemberStatus({{ $member->id }}, '{{ $member->is_active ? 'false' : 'true' }}')">
                                <i class="fas {{ $member->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $member->is_active ? '啟用' : '停用' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title">{{ $member->name }}</h3>
                        <p class="card-position">{{ $member->position }}</p>
                        
                        @if($member->bio)
                            <p class="card-description">{{ Str::limit($member->bio, 100) }}</p>
                        @endif
                        
                        <div class="card-meta">
                            @if($member->skills && count($member->skills) > 0)
                                <span class="meta-item">
                                    <i class="fas fa-code"></i>{{ count($member->skills) }}項技能
                                </span>
                            @endif
                            @if($member->email)
                                <span class="meta-item">
                                    <i class="fas fa-envelope"></i>{{ $member->email }}
                                </span>
                            @endif
                        </div>
                        
                        @if($member->skills && count($member->skills) > 0)
                            <div class="card-skills">
                                @foreach(array_slice($member->skills, 0, 3) as $skill)
                                    <span class="skill-tag">{{ $skill }}</span>
                                @endforeach
                                @if(count($member->skills) > 3)
                                    <span class="skill-tag skill-more">+{{ count($member->skills) - 3 }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-actions">
                        <a href="{{ route('admin.team-members.show', $member) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>查看
                        </a>
                        <a href="{{ route('admin.team-members.edit', $member) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>編輯
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="deleteTeamMember({{ $member->id }}, {{ json_encode($member->name) }})">
                            <i class="fas fa-trash"></i>刪除
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="admin-pagination">
            {{ $teamMembers->links() }}
        </div>
    @else
        <div class="admin-empty">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="empty-title">尚未有團隊成員</h3>
            <p class="empty-description">開始添加您的第一個團隊成員</p>
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
function deleteTeamMember(id, name) {
    showAlertModal({
        title: '確認刪除',
        message: `確定要刪除團隊成員「${name}」嗎？此操作無法復原。`,
        type: 'confirm',
        onConfirm: function() {
            const form = document.getElementById('delete-form');
            form.action = '/admin/team-members/' + id;
            form.submit();
        }
    });
}

function toggleTeamMemberStatus(id, newStatus) {
    const statusText = newStatus === 'true' ? '啟用' : '停用';
    
    showAlertModal({
        title: '確認狀態切換',
        message: `確定要${statusText}此團隊成員嗎？`,
        type: 'confirm',
        onConfirm: function() {
            fetch(`/admin/team-members/${id}/toggle-status`, {
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
</script>
@endpush
