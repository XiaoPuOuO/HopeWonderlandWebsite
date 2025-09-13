// 聯絡訊息管理頁面 JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // 全選功能
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const messageCheckboxes = document.querySelectorAll('.message-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            messageCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    // 全選按鈕
    const selectAllBtn = document.getElementById('select-all');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            messageCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            if (selectAllCheckbox) selectAllCheckbox.checked = true;
        });
    }
    
    // 取消全選按鈕
    const deselectAllBtn = document.getElementById('deselect-all');
    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', function() {
            messageCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            if (selectAllCheckbox) selectAllCheckbox.checked = false;
        });
    }
    
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
    const bulkMarkReadBtn = document.getElementById('bulk-mark-read');
    if (bulkMarkReadBtn) {
        bulkMarkReadBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                bulkAction('mark_read', selectedIds);
            }
        });
    }
    
    const bulkMarkUnreadBtn = document.getElementById('bulk-mark-unread');
    if (bulkMarkUnreadBtn) {
        bulkMarkUnreadBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                bulkAction('mark_unread', selectedIds);
            }
        });
    }
    
    const bulkDeleteBtn = document.getElementById('bulk-delete');
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                showBulkDeleteModal(selectedIds);
            }
        });
    }
    
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
        if (!modal) return;
        
        modal.style.display = 'block';
        
        const confirmBtn = document.getElementById('confirm-delete');
        if (confirmBtn) {
            confirmBtn.onclick = function() {
                deleteMessage(id);
                modal.style.display = 'none';
            };
        }
        
        const cancelBtn = document.getElementById('cancel-delete');
        if (cancelBtn) {
            cancelBtn.onclick = function() {
                modal.style.display = 'none';
            };
        }
        
        const closeBtn = document.querySelector('.modal-close');
        if (closeBtn) {
            closeBtn.onclick = function() {
                modal.style.display = 'none';
            };
        }
    }
    
    function showBulkDeleteModal(ids) {
        const modal = document.getElementById('delete-modal');
        if (!modal) return;
        
        modal.style.display = 'block';
        
        const confirmBtn = document.getElementById('confirm-delete');
        if (confirmBtn) {
            confirmBtn.onclick = function() {
                bulkAction('delete', ids);
                modal.style.display = 'none';
            };
        }
        
        const cancelBtn = document.getElementById('cancel-delete');
        if (cancelBtn) {
            cancelBtn.onclick = function() {
                modal.style.display = 'none';
            };
        }
        
        const closeBtn = document.querySelector('.modal-close');
        if (closeBtn) {
            closeBtn.onclick = function() {
                modal.style.display = 'none';
            };
        }
    }
    
    function deleteMessage(id) {
        fetch(`/admin/contact-messages/${id}`, {
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
});
