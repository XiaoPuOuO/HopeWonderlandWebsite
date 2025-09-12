// HopeWonderland Studio - 全域通知和對話框系統

// 通知系統
window.showNotification = function(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    const iconMap = {
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${iconMap[type] || 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close" onclick="closeNotification(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // 添加到頁面
    document.body.appendChild(notification);
    
    // 顯示動畫
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // 自動關閉
    setTimeout(() => {
        if (notification.parentNode) {
            closeNotification(notification.querySelector('.notification-close'));
        }
    }, 5000);
};

// 關閉通知
window.closeNotification = function(button) {
    const notification = button.closest('.notification');
    notification.classList.remove('show');
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 300);
};

// 確認對話框系統
window.showAlertModal = function(options) {
    const {
        title = '提示',
        message = '',
        type = 'alert', // 'alert' 或 'confirm'
        onConfirm = null,
        onCancel = null
    } = options;
    
    // 創建模態框背景
    const modalOverlay = document.createElement('div');
    modalOverlay.className = 'modal-overlay';
    modalOverlay.id = 'alert-modal-overlay';
    
    // 創建模態框內容
    const modal = document.createElement('div');
    modal.className = 'alert-modal';
    
    const iconMap = {
        alert: 'exclamation-triangle',
        confirm: 'question-circle',
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    
    const colorMap = {
        alert: 'var(--warning-color)',
        confirm: 'var(--primary-color)',
        success: 'var(--success-color)',
        error: 'var(--error-color)',
        warning: 'var(--warning-color)',
        info: 'var(--primary-color)'
    };
    
    const icon = iconMap[type] || 'info-circle';
    const color = colorMap[type] || 'var(--primary-color)';
    
    modal.innerHTML = `
        <div class="alert-modal-content">
            <div class="alert-modal-header">
                <div class="alert-modal-icon" style="color: ${color}">
                    <i class="fas fa-${icon}"></i>
                </div>
                <h3 class="alert-modal-title">${title}</h3>
            </div>
            <div class="alert-modal-body">
                <p class="alert-modal-message">${message}</p>
            </div>
            <div class="alert-modal-footer">
                ${type === 'confirm' ? `
                    <button class="btn btn-secondary alert-modal-cancel">
                        <i class="fas fa-times"></i>取消
                    </button>
                ` : ''}
                <button class="btn btn-primary alert-modal-confirm">
                    <i class="fas fa-check"></i>確定
                </button>
            </div>
        </div>
    `;
    
    modalOverlay.appendChild(modal);
    document.body.appendChild(modalOverlay);
    
    // 顯示動畫
    setTimeout(() => {
        modalOverlay.classList.add('show');
    }, 100);
    
    // 綁定事件
    const confirmBtn = modal.querySelector('.alert-modal-confirm');
    const cancelBtn = modal.querySelector('.alert-modal-cancel');
    
    confirmBtn.addEventListener('click', () => {
        closeAlertModal();
        if (onConfirm && typeof onConfirm === 'function') {
            onConfirm();
        }
    });
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            closeAlertModal();
            if (onCancel && typeof onCancel === 'function') {
                onCancel();
            }
        });
    }
    
    // 點擊背景關閉
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            closeAlertModal();
            if (onCancel && typeof onCancel === 'function') {
                onCancel();
            }
        }
    });
    
    // ESC 鍵關閉
    const handleEsc = (e) => {
        if (e.key === 'Escape') {
            closeAlertModal();
            if (onCancel && typeof onCancel === 'function') {
                onCancel();
            }
            document.removeEventListener('keydown', handleEsc);
        }
    };
    document.addEventListener('keydown', handleEsc);
};

// 關閉對話框
window.closeAlertModal = function() {
    const modalOverlay = document.getElementById('alert-modal-overlay');
    if (modalOverlay) {
        modalOverlay.classList.remove('show');
        setTimeout(() => {
            if (modalOverlay.parentNode) {
                modalOverlay.remove();
            }
        }, 300);
    }
};

// 確認刪除的便捷方法
window.confirmDelete = function(message = '確定要刪除嗎？此操作無法復原。', onConfirm = null) {
    showAlertModal({
        title: '確認刪除',
        message: message,
        type: 'confirm',
        onConfirm: onConfirm,
        onCancel: () => {
            showNotification('操作已取消', 'info');
        }
    });
};

// 成功提示的便捷方法
window.showSuccess = function(message) {
    showNotification(message, 'success');
};

// 錯誤提示的便捷方法
window.showError = function(message) {
    showNotification(message, 'error');
};

// 警告提示的便捷方法
window.showWarning = function(message) {
    showNotification(message, 'warning');
};

// 資訊提示的便捷方法
window.showInfo = function(message) {
    showNotification(message, 'info');
};
