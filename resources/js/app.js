// HopeWonderland Studio 主 JavaScript 檔案

// 等待 DOM 載入完成
document.addEventListener('DOMContentLoaded', function() {
    // 初始化所有功能
    initMobileMenu();
    initSmoothScrolling();
    initFormValidation();
    initColorPickers();
    initTagManagement();
    initScrollAnimations();
    initPortfolioFilter();
    initTypingAnimation();
    initParallaxEffects();
    initCounterAnimation();
    initThemeToggle();
});

// 手機版選單切換
function initMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
}

// 平滑滾動
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// 表單驗證
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    showFieldError(field, '此欄位為必填');
                } else {
                    field.classList.remove('border-red-500');
                    hideFieldError(field);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('請填寫所有必填欄位', 'error');
            }
        });
    });
}

// 顯示欄位錯誤
function showFieldError(field, message) {
    let errorElement = field.parentNode.querySelector('.field-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'field-error text-red-600 text-sm mt-1';
        field.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
}

// 隱藏欄位錯誤
function hideFieldError(field) {
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

// 色彩選擇器同步
function initColorPickers() {
    const colorPickers = document.querySelectorAll('input[type="color"]');
    
    colorPickers.forEach(picker => {
        const textInput = document.getElementById(picker.id + '_text');
        
        if (textInput) {
            picker.addEventListener('input', function() {
                textInput.value = this.value;
            });
            
            textInput.addEventListener('input', function() {
                picker.value = this.value;
            });
        }
    });
}

// 標籤管理
function initTagManagement() {
    // 添加標籤功能
    window.addTag = function() {
        const container = document.getElementById('tags-container');
        if (container) {
            const newTag = document.createElement('div');
            newTag.className = 'flex items-center space-x-2';
            newTag.innerHTML = `
                <input type="text" 
                       name="tags[]" 
                       placeholder="輸入標籤"
                       class="form-control">
                <button type="button" 
                        onclick="removeTag(this)" 
                        class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(newTag);
        }
    };
    
    // 移除標籤功能
    window.removeTag = function(button) {
        button.parentElement.remove();
    };
}

// 確認刪除對話框
function confirmDelete(message = '確定要刪除嗎？此操作無法復原。') {
    return confirm(message);
}

// 顯示通知
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${getNotificationIcon(type)} mr-2"></i>
            ${message}
        </div>
    `;
    
    // 添加到頁面
    document.body.appendChild(notification);
    
    // 自動移除
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// 獲取通知圖標
function getNotificationIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'exclamation-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// 載入動畫
function showLoading(element) {
    element.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>載入中...';
    element.disabled = true;
}

function hideLoading(element, originalText) {
    element.innerHTML = originalText;
    element.disabled = false;
}

// 工具函數
const utils = {
    // 防抖函數
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    // 節流函數
    throttle: function(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },
    
    // 格式化日期
    formatDate: function(date) {
        return new Date(date).toLocaleDateString('zh-TW', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    },
    
    // 複製到剪貼板
    copyToClipboard: function(text) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('已複製到剪貼板', 'success');
        }).catch(() => {
            showNotification('複製失敗', 'error');
        });
    }
};

// 滾動動畫效果
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // 觀察需要動畫的元素
    const animateElements = document.querySelectorAll('.service-card, .brand-card, .team-card, .portfolio-item, .value-card, .expertise-card, .process-step');
    animateElements.forEach(el => {
        observer.observe(el);
    });
}

// 作品集篩選功能
function initPortfolioFilter() {
    // 檢查是否在作品集頁面
    if (!document.querySelector('.portfolio-filter')) {
        return; // 不在作品集頁面，直接返回
    }
    
    const filterToggle = document.getElementById('filter-toggle');
    const filterMenu = document.getElementById('filter-menu');
    const filterOptions = document.querySelectorAll('.filter-option');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    const resultsCount = document.getElementById('results-count');
    const selectedText = document.querySelector('.filter-selected-text');
    
    // 檢查必要的元素是否存在
    if (!filterToggle || !filterMenu || !resultsCount || !selectedText) {
        console.log('作品集篩選元素未找到，跳過初始化');
        return;
    }
    
    // 動態生成分類選項（只顯示存在的分類）
    const existingCategories = new Set();
    portfolioItems.forEach(item => {
        const category = item.getAttribute('data-category');
        if (category) {
            existingCategories.add(category);
        }
    });
    
    // 隱藏不存在的分類選項
    filterOptions.forEach(option => {
        const filter = option.getAttribute('data-filter');
        if (filter !== 'all' && !existingCategories.has(filter)) {
            option.style.display = 'none';
        }
    });
    
    // Dropdown 切換
    filterToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        filterMenu.classList.toggle('show');
        filterToggle.classList.toggle('active');
    });
    
    // 點擊外部關閉 dropdown
    document.addEventListener('click', function(e) {
        if (!filterToggle.contains(e.target) && !filterMenu.contains(e.target)) {
            filterMenu.classList.remove('show');
            filterToggle.classList.remove('active');
        }
    });
    
    // 選項點擊處理
    filterOptions.forEach(option => {
        option.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // 更新選中狀態
            filterOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // 更新顯示文字
            const text = this.querySelector('span').textContent;
            selectedText.textContent = text;
            
            // 關閉 dropdown
            filterMenu.classList.remove('show');
            filterToggle.classList.remove('active');
            
            // 篩選作品
            filterPortfolioItems(filter, portfolioItems, resultsCount);
        });
    });
    
    // 初始化顯示所有項目
    filterPortfolioItems('all', portfolioItems, resultsCount);
}

function filterPortfolioItems(filter, portfolioItems, resultsCount) {
    if (!resultsCount) {
        console.log('結果計數元素未找到');
        return;
    }
    
    let visibleCount = 0;
    
    portfolioItems.forEach(item => {
        const category = item.getAttribute('data-category');
        
        if (filter === 'all' || category === filter) {
            item.style.display = 'block';
            setTimeout(() => {
                item.classList.add('animate-in');
            }, 100);
            visibleCount++;
        } else {
            item.classList.remove('animate-in');
            setTimeout(() => {
                item.style.display = 'none';
            }, 300);
        }
    });
    
    // 更新結果計數
    resultsCount.textContent = visibleCount;
}

// 打字動畫效果
function initTypingAnimation() {
    const typingElements = document.querySelectorAll('.typing-animation');
    
    typingElements.forEach(element => {
        const text = element.textContent;
        element.textContent = '';
        
        let i = 0;
        const typeWriter = () => {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        };
        
        // 當元素進入視窗時開始打字動畫
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    typeWriter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(element);
    });
}

// 視差效果
function initParallaxEffects() {
    const parallaxElements = document.querySelectorAll('.parallax');
    
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const rate = scrolled * -0.5;
            element.style.transform = `translateY(${rate}px)`;
        });
    });
}

// 數字計數動畫
function initCounterAnimation() {
    const numberElements = document.querySelectorAll('.stat-number, .counter');
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumber(entry.target);
                observer.unobserve(entry.target);
            }
        });
    });
    
    numberElements.forEach(el => {
        observer.observe(el);
    });
}

// 動畫數字函數
function animateNumber(element) {
    const target = parseInt(element.textContent.replace(/[^\d]/g, ''));
    const duration = 2000; // 2秒
    const increment = target / (duration / 16); // 60fps
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        
        // 保持原始格式
        const originalText = element.textContent;
        const suffix = originalText.replace(/[\d,]/g, '');
        element.textContent = Math.floor(current).toLocaleString() + suffix;
    }, 16);
}

// 導出工具函數供全域使用
window.utils = utils;

// 主題切換功能
function initThemeToggle() {
    const themeToggle = document.getElementById('theme-toggle');
    const mobileThemeToggle = document.getElementById('mobile-theme-toggle');
    const adminThemeToggle = document.getElementById('admin-theme-toggle');
    
    // 從 localStorage 讀取主題設定
    const savedTheme = localStorage.getItem('theme') || 'dark';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);
    
    // 桌面版主題切換
    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleTheme();
        });
    }
    
    // 手機版主題切換
    if (mobileThemeToggle) {
        mobileThemeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleTheme();
            // 關閉手機選單
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
    
    // 管理後台主題切換
    if (adminThemeToggle) {
        adminThemeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleTheme();
        });
    }
}

// 切換主題
function toggleTheme() {
    try {
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
        
        // 顯示切換通知
        if (typeof window.showNotification === 'function') {
            window.showNotification(
                `已切換到${newTheme === 'dark' ? '暗色' : '亮色'}模式`,
                'success'
            );
        }
    } catch (error) {
        console.error('主題切換失敗:', error);
        if (typeof window.showNotification === 'function') {
            window.showNotification('主題切換失敗', 'error');
        }
    }
}

// 更新主題圖標
function updateThemeIcon(theme) {
    try {
        const desktopIcon = document.querySelector('#theme-toggle i');
        const mobileIcon = document.querySelector('#mobile-theme-toggle i');
        const adminIcon = document.querySelector('#admin-theme-toggle i');
        
        const iconClass = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
        
        if (desktopIcon) desktopIcon.className = iconClass;
        if (mobileIcon) mobileIcon.className = iconClass;
        if (adminIcon) adminIcon.className = iconClass;
    } catch (error) {
        console.error('更新主題圖標失敗:', error);
    }
}
