// HopeWonderland Studio - 團隊頁面功能
// 處理技能標籤的展開/收合功能

/**
 * 切換技能標籤的顯示/隱藏
 * @param {number} memberId - 團隊成員 ID
 */
function toggleSkills(memberId) {
    const hiddenSkills = document.getElementById('skills-' + memberId);
    const moreButton = document.querySelector(`[data-member-id="${memberId}"].skill-more`);
    
    if (!hiddenSkills || !moreButton) {
        console.warn(`找不到成員 ID ${memberId} 的相關元素`);
        return;
    }
    
    if (hiddenSkills.style.display === 'none' || hiddenSkills.style.display === '') {
        // 顯示隱藏的標籤
        hiddenSkills.style.display = 'flex';
        moreButton.textContent = '收起';
        moreButton.classList.add('skill-less');
    } else {
        // 隱藏標籤
        hiddenSkills.style.display = 'none';
        moreButton.textContent = '+' + (hiddenSkills.children.length);
        moreButton.classList.remove('skill-less');
    }
}

/**
 * 初始化團隊頁面功能
 */
function initTeamPage() {
    // 為所有技能標籤容器添加點擊事件
    const skillContainers = document.querySelectorAll('.team-skills');
    
    skillContainers.forEach(container => {
        const memberId = container.getAttribute('data-member-id');
        const moreButton = container.querySelector('.skill-more');
        
        if (moreButton && memberId) {
            // 確保初始狀態正確
            const hiddenSkills = document.getElementById('skills-' + memberId);
            if (hiddenSkills) {
                hiddenSkills.style.display = 'none';
                moreButton.textContent = '+' + hiddenSkills.children.length;
                
                // 添加點擊事件
                moreButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    toggleSkills(parseInt(memberId));
                });
            }
        }
    });
}

// 頁面載入完成後初始化
document.addEventListener('DOMContentLoaded', function() {
    initTeamPage();
});

// 導出函數供外部使用（如果需要）
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        toggleSkills,
        initTeamPage
    };
}
