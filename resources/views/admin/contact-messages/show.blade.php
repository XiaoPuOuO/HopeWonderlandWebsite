@extends('layouts.admin')


@section('head')
    @vite(['resources/css/contact.css', 'resources/css/contact-messages-show.css'])
@endsection

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">聯絡訊息詳情</h1>
        <p class="admin-description">查看完整的聯絡訊息內容</p>
    </div>
    <div class="admin-header-actions">
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>返回列表
        </a>
    </div>
</div>

<div class="admin-content">
    <div class="message-detail-container">
        <!-- 訊息基本資訊 -->
        <div class="message-info-card">
            <div class="message-header">
                <div class="message-title">
                    <h2>{{ $contactMessage->name }}</h2>
                    <div class="message-meta">
                        <span class="source-badge source-{{ $contactMessage->source }}">
                            {{ $contactMessage->source_display }}
                        </span>
                        @if($contactMessage->is_read)
                            <span class="status-badge status-read">
                                <i class="fas fa-check"></i>已讀
                            </span>
                        @else
                            <span class="status-badge status-unread">
                                <i class="fas fa-envelope"></i>未讀
                            </span>
                        @endif
                    </div>
                </div>
                <div class="message-actions">
                    @if($contactMessage->is_read)
                        <button type="button" class="btn btn-warning mark-unread-btn" 
                                data-id="{{ $contactMessage->id }}">
                            <i class="fas fa-envelope"></i>標記為未讀
                        </button>
                    @else
                        <button type="button" class="btn btn-success mark-read-btn" 
                                data-id="{{ $contactMessage->id }}">
                            <i class="fas fa-envelope-open"></i>標記為已讀
                        </button>
                    @endif
                    <button type="button" class="btn btn-danger delete-btn" 
                            data-id="{{ $contactMessage->id }}">
                        <i class="fas fa-trash"></i>刪除
                    </button>
                </div>
            </div>
            
            <div class="message-content">
                <div class="message-details">
                    <div class="detail-row">
                        <div class="detail-label">姓名</div>
                        <div class="detail-value">{{ $contactMessage->name }}</div>
                    </div>
                    
                    <div class="detail-row">
                        <div class="detail-label">電子郵件</div>
                        <div class="detail-value">
                            <a href="mailto:{{ $contactMessage->email }}" class="email-link">
                                {{ $contactMessage->email }}
                            </a>
                        </div>
                    </div>
                    
                    @if($contactMessage->company)
                        <div class="detail-row">
                            <div class="detail-label">公司名稱</div>
                            <div class="detail-value">{{ $contactMessage->company }}</div>
                        </div>
                    @endif
                    
                    @if($contactMessage->phone)
                        <div class="detail-row">
                            <div class="detail-label">電話</div>
                            <div class="detail-value">
                                <a href="tel:{{ $contactMessage->phone }}" class="phone-link">
                                    {{ $contactMessage->phone }}
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    @if($contactMessage->service)
                        <div class="detail-row">
                            <div class="detail-label">服務類型</div>
                            <div class="detail-value">
                                <span class="service-badge">{{ $contactMessage->service_display }}</span>
                            </div>
                        </div>
                    @endif
                    
                    @if($contactMessage->budget)
                        <div class="detail-row">
                            <div class="detail-label">預算範圍</div>
                            <div class="detail-value">{{ $contactMessage->budget_display }}</div>
                        </div>
                    @endif
                    
                    @if($contactMessage->timeline)
                        <div class="detail-row">
                            <div class="detail-label">專案時程</div>
                            <div class="detail-value">{{ $contactMessage->timeline_display }}</div>
                        </div>
                    @endif
                    
                    <div class="detail-row">
                        <div class="detail-label">建立時間</div>
                        <div class="detail-value">
                            <div class="time-info">
                                <div class="date">{{ $contactMessage->created_at->format('Y年m月d日') }}</div>
                                <div class="time">{{ $contactMessage->created_at->format('H:i:s') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($contactMessage->read_at)
                        <div class="detail-row">
                            <div class="detail-label">已讀時間</div>
                            <div class="detail-value">
                                <div class="time-info">
                                    <div class="date">{{ $contactMessage->read_at->format('Y年m月d日') }}</div>
                                    <div class="time">{{ $contactMessage->read_at->format('H:i:s') }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="message-text">
                    <div class="message-label">專案描述</div>
                    <div class="message-body">
                        {{ $contactMessage->message }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 快速回覆 -->
        <div class="quick-reply-card">
            <h3 class="card-title">快速回覆</h3>
            <form class="reply-form">
                <div class="form-group">
                    <label for="reply-subject" class="form-label">主旨</label>
                    <input type="text" id="reply-subject" class="form-control" 
                           value="回覆：{{ $contactMessage->name }} 的諮詢">
                </div>
                
                <div class="form-group">
                    <label for="reply-message" class="form-label">回覆內容</label>
                    <textarea id="reply-message" rows="6" class="form-control" 
                              placeholder="請輸入回覆內容..."></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-primary" id="send-reply">
                        <i class="fas fa-paper-plane"></i>發送回覆
                    </button>
                    <button type="button" class="btn btn-secondary" id="copy-email">
                        <i class="fas fa-copy"></i>複製郵件地址
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 確認刪除對話框 -->
<div id="delete-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">確認刪除</h3>
            <button type="button" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <p>您確定要刪除這則訊息嗎？此操作無法復原。</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancel-delete">取消</button>
            <button type="button" class="btn btn-danger" id="confirm-delete">刪除</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 標記為已讀
    document.querySelector('.mark-read-btn')?.addEventListener('click', function() {
        const id = this.dataset.id;
        markAsRead(id);
    });
    
    // 標記為未讀
    document.querySelector('.mark-unread-btn')?.addEventListener('click', function() {
        const id = this.dataset.id;
        markAsUnread(id);
    });
    
    // 刪除按鈕
    document.querySelector('.delete-btn')?.addEventListener('click', function() {
        const id = this.dataset.id;
        showDeleteModal(id);
    });
    
    // 複製郵件地址
    document.getElementById('copy-email')?.addEventListener('click', function() {
        navigator.clipboard.writeText('{{ $contactMessage->email }}').then(() => {
            alert('郵件地址已複製到剪貼簿');
        });
    });
    
    // 發送回覆
    document.getElementById('send-reply')?.addEventListener('click', function() {
        const subject = document.getElementById('reply-subject').value;
        const message = document.getElementById('reply-message').value;
        
        if (!message.trim()) {
            alert('請輸入回覆內容');
            return;
        }
        
        const mailtoLink = 'mailto:{{ $contactMessage->email }}?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(message);
        window.location.href = mailtoLink;
    });
    
    function markAsRead(id) {
        fetch('/admin/contact-messages/' + id + '/mark-read', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
    
    function markAsUnread(id) {
        fetch('/admin/contact-messages/' + id + '/mark-unread', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
    
    function showDeleteModal(id) {
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'block';
        
        document.getElementById('confirm-delete').onclick = function() {
            deleteMessage(id);
            modal.style.display = 'none';
        };
        
        document.getElementById('cancel-delete').onclick = function() {
            modal.style.display = 'none';
        };
        
        document.querySelector('.modal-close').onclick = function() {
            modal.style.display = 'none';
        };
    }
    
    function deleteMessage(id) {
        fetch('/admin/contact-messages/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("admin.contact-messages.index") }}';
            }
        });
    }
});
</script>


@endsection
