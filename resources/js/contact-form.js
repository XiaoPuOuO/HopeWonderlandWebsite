// 聯絡頁面 JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // 嘗試找到聯絡表單（支援多個表單）
    const contactForm = document.getElementById('contact-form');
    const homeContactForm = document.getElementById('home-contact-form');
    const form = contactForm || homeContactForm;
    
    const alertDiv = document.getElementById('message-alert') || document.getElementById('home-message-alert');
    const messageText = document.getElementById('message-text');
    
    // 檢查必要的元素是否存在
    if (!form) {
        console.log('聯絡表單未找到，跳過初始化');
        return;
    }
    
    const submitBtn = form.querySelector('button[type="submit"]');
    
    if (!submitBtn) {
        console.log('提交按鈕未找到，跳過初始化');
        return;
    }
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // 禁用提交按鈕
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>發送中...';
        
        // 收集表單資料
        const formData = new FormData(form);
        formData.append('source', form.id === 'home-contact-form' ? 'home' : 'contact');
        
        try {
            const response = await fetch('/contact', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                // 成功訊息
                showAlert('success', result.message);
                form.reset();
            } else {
                // 錯誤訊息
                showAlert('error', result.message);
                
                // 顯示驗證錯誤
                if (result.errors) {
                    Object.keys(result.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('error');
                        }
                    });
                }
            }
        } catch (error) {
            showAlert('error', '發送失敗，請稍後再試。');
        } finally {
            // 恢復提交按鈕
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i>發送訊息';
        }
    });
    
    function showAlert(type, message) {
        if (!alertDiv) {
            console.log('警告區域未找到');
            return;
        }
        
        alertDiv.innerHTML = `
            <div class="alert alert-${type}">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${message}
            </div>
        `;
        alertDiv.style.display = 'block';
        
        // 3秒後自動隱藏
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 3000);
    }
    
    // 移除錯誤樣式
    form.addEventListener('input', function(e) {
        e.target.classList.remove('error');
    });
    
    // 字數統計
    if (messageText) {
        const charCount = document.createElement('div');
        charCount.className = 'char-count';
        charCount.style.textAlign = 'right';
        charCount.style.fontSize = '12px';
        charCount.style.color = '#666';
        charCount.style.marginTop = '5px';
        messageText.parentNode.appendChild(charCount);
        
        function updateCharCount() {
            const count = messageText.value.length;
            charCount.textContent = `${count}/2000`;
            
            if (count > 2000) {
                charCount.style.color = '#dc3545';
            } else if (count > 1800) {
                charCount.style.color = '#ffc107';
            } else {
                charCount.style.color = '#666';
            }
        }
        
        messageText.addEventListener('input', updateCharCount);
        updateCharCount();
    }
});
