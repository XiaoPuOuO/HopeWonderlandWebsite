// 首頁聯絡表單處理
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('home-contact-form');
    const alertDiv = document.getElementById('home-message-alert');
    const messageText = document.getElementById('home-message-text');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // 禁用提交按鈕
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>發送中...';
        
        // 收集表單資料
        const formData = new FormData(form);
        formData.append('source', 'home');
        
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
        alertDiv.className = 'alert alert-' + type;
        messageText.textContent = message;
        alertDiv.style.display = 'block';
        
        // 5秒後自動隱藏
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 5000);
    }
});