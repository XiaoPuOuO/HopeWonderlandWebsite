@extends('layouts.admin')


@section('head')
    @vite(['resources/css/contact.css', 'resources/js/contact.js'])
@endsection

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">聯絡訊息管理</h1>
        <p class="admin-description">管理來自聯絡我們頁面和首頁的訊息</p>
    </div>
</div>

<div class="admin-content">
    <!-- 統計卡片 -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="total-messages">{{ $messages->total() }}</h3>
                <p class="stat-label">總訊息數</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon unread">
                <i class="fas fa-envelope-open"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="unread-messages">{{ $messages->where('is_read', false)->count() }}</h3>
                <p class="stat-label">未讀訊息</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number" id="today-messages">{{ $messages->where('created_at', '>=', today())->count() }}</h3>
                <p class="stat-label">今日訊息</p>
            </div>
        </div>
    </div>

    <!-- 篩選和搜尋 -->
    <div class="admin-filters">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label for="search" class="filter-label">搜尋</label>
                <input type="text" id="search" name="search" class="filter-input" 
                       value="{{ request('search') }}" placeholder="搜尋姓名、郵件或內容...">
            </div>
            
            <div class="filter-group">
                <label for="status" class="filter-label">狀態</label>
                <select id="status" name="status" class="filter-select">
                    <option value="">全部</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>未讀</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>已讀</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="source" class="filter-label">來源</label>
                <select id="source" name="source" class="filter-select">
                    <option value="">全部</option>
                    <option value="contact" {{ request('source') === 'contact' ? 'selected' : '' }}>聯絡我們頁面</option>
                    <option value="home" {{ request('source') === 'home' ? 'selected' : '' }}>首頁</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="sort_by" class="filter-label">排序</label>
                <select id="sort_by" name="sort_by" class="filter-select">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>建立時間</option>
                    <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>姓名</option>
                    <option value="email" {{ request('sort_by') === 'email' ? 'selected' : '' }}>郵件</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="sort_order" class="filter-label">順序</label>
                <select id="sort_order" name="sort_order" class="filter-select">
                    <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>降序</option>
                    <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>升序</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>篩選
            </button>
            
            <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>清除
            </a>
        </form>
    </div>

    <!-- 批量操作 -->
    <div class="bulk-actions">
        <div class="bulk-actions-left">
            <button type="button" class="btn btn-secondary" id="select-all">
                <i class="fas fa-check-square"></i>全選
            </button>
            <button type="button" class="btn btn-secondary" id="deselect-all">
                <i class="fas fa-square"></i>取消全選
            </button>
        </div>
        
        <div class="bulk-actions-right">
            <button type="button" class="btn btn-success" id="bulk-mark-read">
                <i class="fas fa-envelope-open"></i>標記為已讀
            </button>
            <button type="button" class="btn btn-warning" id="bulk-mark-unread">
                <i class="fas fa-envelope"></i>標記為未讀
            </button>
            <button type="button" class="btn btn-danger" id="bulk-delete">
                <i class="fas fa-trash"></i>刪除
            </button>
        </div>
    </div>

    <!-- 訊息列表 -->
    <div class="admin-table-container">
        @if($messages->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="checkbox-column">
                            <input type="checkbox" id="select-all-checkbox">
                        </th>
                        <th>姓名</th>
                        <th>郵件</th>
                        <th>公司</th>
                        <th>服務類型</th>
                        <th>來源</th>
                        <th>狀態</th>
                        <th>建立時間</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr class="{{ $message->is_read ? '' : 'unread-row' }}">
                            <td class="checkbox-column">
                                <input type="checkbox" class="message-checkbox" value="{{ $message->id }}">
                            </td>
                            <td>
                                <div class="message-name">
                                    {{ $message->name }}
                                    @if(!$message->is_read)
                                        <span class="unread-badge">未讀</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $message->email }}" class="email-link">
                                    {{ $message->email }}
                                </a>
                            </td>
                            <td>{{ $message->company ?? '-' }}</td>
                            <td>
                                @if($message->service)
                                    <span class="service-badge">{{ $message->service_display }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="source-badge source-{{ $message->source }}">
                                    {{ $message->source_display }}
                                </span>
                            </td>
                            <td>
                                @if($message->is_read)
                                    <span class="status-badge status-read">
                                        <i class="fas fa-check"></i>已讀
                                    </span>
                                @else
                                    <span class="status-badge status-unread">
                                        <i class="fas fa-envelope"></i>未讀
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="time-info">
                                    <div class="date">{{ $message->created_at->format('Y-m-d') }}</div>
                                    <div class="time">{{ $message->created_at->format('H:i') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.contact-messages.show', $message) }}" 
                                       class="btn btn-sm btn-primary" title="查看詳情">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($message->is_read)
                                        <button type="button" class="btn btn-sm btn-warning mark-unread-btn" 
                                                data-id="{{ $message->id }}" title="標記為未讀">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-success mark-read-btn" 
                                                data-id="{{ $message->id }}" title="標記為已讀">
                                            <i class="fas fa-envelope-open"></i>
                                        </button>
                                    @endif
                                    
                                    <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                            data-id="{{ $message->id }}" title="刪除">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- 分頁 -->
            <div class="pagination-container">
                {{ $messages->appends(request()->query())->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3 class="empty-title">暫無聯絡訊息</h3>
                <p class="empty-description">目前沒有任何聯絡訊息</p>
            </div>
        @endif
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
    // 全選功能
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const messageCheckboxes = document.querySelectorAll('.message-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        messageCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // 全選按鈕
    document.getElementById('select-all').addEventListener('click', function() {
        messageCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        selectAllCheckbox.checked = true;
    });
    
    // 取消全選按鈕
    document.getElementById('deselect-all').addEventListener('click', function() {
        messageCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        selectAllCheckbox.checked = false;
    });
    
    // 標記為已讀
    document.querySelectorAll('.mark-read-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            markAsRead(id);
        });
    });
    
    // 標記為未讀
    document.querySelectorAll('.mark-unread-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            markAsUnread(id);
        });
    });
    
    // 刪除按鈕
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            showDeleteModal(id);
        });
    });
    
    // 批量操作
    document.getElementById('bulk-mark-read').addEventListener('click', function() {
        const selectedIds = getSelectedIds();
        if (selectedIds.length > 0) {
            bulkAction('mark_read', selectedIds);
        }
    });
    
    document.getElementById('bulk-mark-unread').addEventListener('click', function() {
        const selectedIds = getSelectedIds();
        if (selectedIds.length > 0) {
            bulkAction('mark_unread', selectedIds);
        }
    });
    
    document.getElementById('bulk-delete').addEventListener('click', function() {
        const selectedIds = getSelectedIds();
        if (selectedIds.length > 0) {
            showBulkDeleteModal(selectedIds);
        }
    });
    
    function getSelectedIds() {
        return Array.from(document.querySelectorAll('.message-checkbox:checked'))
                   .map(checkbox => checkbox.value);
    }
    
    function markAsRead(id) {
        fetch(`/admin/contact-messages/${id}/mark-read`, {
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
        fetch(`/admin/contact-messages/${id}/mark-unread`, {
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
    
    function bulkAction(action, ids) {
        fetch('/admin/contact-messages/bulk-action', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: action,
                ids: ids
            })
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
    
    function showBulkDeleteModal(ids) {
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'block';
        
        document.getElementById('confirm-delete').onclick = function() {
            bulkAction('delete', ids);
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
                location.reload();
            }
        });
    }
@endsection
