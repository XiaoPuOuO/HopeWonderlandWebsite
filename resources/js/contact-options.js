// 聯絡選項管理頁面 JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // 全選功能 - 服務類型
    const selectAllServiceCheckbox = document.getElementById('select-all-service');
    const serviceCheckboxes = document.querySelectorAll('tbody tr input.option-checkbox');
    
    if (selectAllServiceCheckbox) {
        selectAllServiceCheckbox.addEventListener('change', function() {
            serviceCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    // 全選功能 - 預算範圍
    const selectAllBudgetCheckbox = document.getElementById('select-all-budget');
    
    if (selectAllBudgetCheckbox) {
        selectAllBudgetCheckbox.addEventListener('change', function() {
            const budgetTable = this.closest('.card').querySelector('tbody');
            if (budgetTable) {
                const budgetCheckboxes = budgetTable.querySelectorAll('input.option-checkbox');
                budgetCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            }
        });
    }
    
    // 移除舊的狀態切換按鈕事件監聽器（因為已經移除眼睛按鈕）
    
    // 狀態切換按鈕（新的可點擊狀態 badge）
    document.querySelectorAll('.status-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const action = this.dataset.action;
            toggleStatus(id, action);
        });
    });
    
    // 刪除按鈕
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            showDeleteConfirm(id);
        });
    });
    
    // 批量操作按鈕
    const bulkActivateBtn = document.getElementById('bulk-activate');
    const bulkDeactivateBtn = document.getElementById('bulk-deactivate');
    const bulkDeleteBtn = document.getElementById('bulk-delete');
    
    if (bulkActivateBtn) {
        bulkActivateBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                showBulkModal('activate', '啟用', selectedIds);
            } else {
                showAlert('請選擇要操作的選項', 'warning');
            }
        });
    }
    
    if (bulkDeactivateBtn) {
        bulkDeactivateBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                showBulkModal('deactivate', '停用', selectedIds);
            } else {
                showAlert('請選擇要操作的選項', 'warning');
            }
        });
    }
    
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                showBulkDeleteConfirm(selectedIds);
            } else {
                showAlert('請選擇要操作的選項', 'warning');
            }
        });
    }
    
    function getSelectedIds() {
        return Array.from(document.querySelectorAll('.option-checkbox:checked'))
                   .map(checkbox => checkbox.value);
    }
    
    function toggleStatus(id, action) {
        const url = `/admin/contact-options/${id}/toggle-status`;
        const method = 'PATCH';
        
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: action
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatusButton(id, action);
                showAlert(data.message, 'success');
            } else {
                showAlert(data.message || '操作失敗', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('操作失敗，請稍後再試', 'error');
        });
    }
    
    function showDeleteConfirm(id) {
        showAlertModal({
            title: '確認刪除',
            message: '確定要刪除此選項嗎？此操作無法復原。',
            type: 'confirm',
            onConfirm: function() {
                deleteOption(id);
            },
            onCancel: function() {
                // 不需要做任何事
            }
        });
    }
    
    function showBulkDeleteConfirm(ids) {
        showAlertModal({
            title: '確認批量刪除',
            message: `確定要刪除所選的 ${ids.length} 個選項嗎？此操作無法復原。`,
            type: 'confirm',
            onConfirm: function() {
                bulkAction('delete', ids);
            },
            onCancel: function() {
                // 不需要做任何事
            }
        });
    }
    
    function showBulkModal(action, actionText, ids) {
        // 保留此函數用於批量啟用/停用操作
        const modal = document.getElementById('bulk-modal');
        if (!modal) return;
        
        const title = document.getElementById('bulk-modal-title');
        const body = document.getElementById('bulk-modal-body');
        
        if (title) title.textContent = `確認${actionText}`;
        if (body) body.textContent = `確定要${actionText}所選的 ${ids.length} 個選項嗎？`;
        
        modal.style.display = 'block';
        modal.classList.add('show');
        
        const confirmBtn = document.getElementById('confirm-bulk-action');
        if (confirmBtn) {
            confirmBtn.onclick = function() {
                bulkAction(action, ids);
                modal.style.display = 'none';
                modal.classList.remove('show');
            };
        }
        
        const cancelBtn = modal.querySelector('[data-bs-dismiss="modal"]');
        if (cancelBtn) {
            cancelBtn.onclick = function() {
                modal.style.display = 'none';
                modal.classList.remove('show');
            };
        }
    }
    
    function deleteOption(id) {
        fetch(`/admin/contact-options/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showAlert(data.message || '刪除成功', 'success');
                // 移除對應的表格行
                const row = document.querySelector(`button.delete-btn[data-id="${id}"]`).closest('tr');
                if (row) {
                    row.remove();
                }
            } else {
                showAlert(data.message || '刪除失敗', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('刪除失敗，請稍後再試', 'error');
        });
    }
    
    function bulkAction(action, ids) {
        fetch('/admin/contact-options/bulk-action', {
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
            } else {
                showAlert(data.message || '批量操作失敗', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('批量操作失敗，請稍後再試', 'error');
        });
    }
    
    function updateStatusButton(id, action) {
        // 找到對應的狀態按鈕
        const button = document.querySelector(`.status-toggle[data-id="${id}"]`);
        if (!button) return;
        
        if (action === 'activate') {
            // 從停用變為啟用
            button.className = 'badge bg-success status-toggle';
            button.textContent = '啟用';
            button.dataset.action = 'deactivate';
            
            // 移除行的停用樣式
            const row = button.closest('tr');
            if (row) {
                row.classList.remove('table-secondary');
            }
        } else {
            // 從啟用變為停用
            button.className = 'badge bg-secondary status-toggle';
            button.textContent = '停用';
            button.dataset.action = 'activate';
            
            // 添加行的停用樣式
            const row = button.closest('tr');
            if (row) {
                row.classList.add('table-secondary');
            }
        }
    }
    
    function showAlert(message, type) {
        // 使用全局的 showNotification 函數
        if (typeof showNotification === 'function') {
            showNotification(message, type);
        } else {
            // 如果 showNotification 不存在，使用 alert 作為備用
            alert(message);
        }
    }
});

