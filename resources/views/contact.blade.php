@extends('layouts.app')

@section('description', '聯繫 HopeWonderland Studio，我們提供專業的技術諮詢服務，為您的專案提供最佳解決方案。')

@section('head')
    @vite(['resources/css/contact-form.css', 'resources/js/contact-page.js'])
@endsection

@section('content')
<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">聯絡我們</h1>
            <p class="hero-description">
                準備開始您的專案了嗎？讓我們一起創造優秀的科技解決方案
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-content">
            <!-- Contact Info -->
            <div class="contact-info">
                <h2 class="contact-title">取得聯繫</h2>
                <p class="contact-description">
                    我們很樂意聽到您的想法和需求。請選擇最適合的聯絡方式與我們聯繫。
                </p>
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="method-content">
                            <h3 class="method-title">電子郵件</h3>
                            <p class="method-description">最適合詳細的專案討論</p>
                            <a href="mailto:contact@hopewonderland.com" class="method-link">
                                contact@hopewonderland.com
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="method-content">
                            <h3 class="method-title">電話</h3>
                            <p class="method-description">週一至週五 9:00-18:00</p>
                            <a href="tel:+886212345678" class="method-link">
                                +886 2 1234 5678
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="method-content">
                            <h3 class="method-title">地址</h3>
                            <p class="method-description">歡迎預約參觀我們的辦公室</p>
                            <span class="method-link">
                                台北市信義區信義路五段7號
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="social-section">
                    <h3 class="social-title">關注我們</h3>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="contact-form">
                <h2 class="form-title">發送訊息</h2>
                <form class="form" id="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">姓名 *</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">電子郵件 *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="company" class="form-label">公司名稱</label>
                            <input type="text" id="company" name="company" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">電話</label>
                            <input type="tel" id="phone" name="phone" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="service" class="form-label">服務類型 *</label>
                        <select id="service" name="service" class="form-control" required>
                            <option value="">請選擇服務類型</option>
                            @foreach($serviceOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="budget" class="form-label">預算範圍</label>
                        <select id="budget" name="budget" class="form-control">
                            <option value="">請選擇預算範圍</option>
                            @foreach($budgetOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="timeline" class="form-label">專案時程</label>
                        <select id="timeline" name="timeline" class="form-control">
                            <option value="">請選擇專案時程</option>
                            <option value="urgent">緊急（1個月內）</option>
                            <option value="fast">快速（1-3個月）</option>
                            <option value="normal">正常（3-6個月）</option>
                            <option value="flexible">彈性（6個月以上）</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">專案描述 *</label>
                        <textarea id="message" name="message" rows="5" class="form-control" 
                                  placeholder="請詳細描述您的專案需求、目標和期望..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="privacy" required>
                            <span class="checkmark"></span>
                            我同意 <a href="#" class="privacy-link">隱私政策</a> 和 <a href="#" class="privacy-link">服務條款</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-paper-plane"></i>發送訊息
                    </button>
                </form>
                
                <!-- 訊息提示區域 -->
                <div id="message-alert" class="alert" style="display: none; margin-top: 20px;">
                    <span id="message-text"></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">常見問題</h2>
            <p class="section-description">
                以下是客戶最常詢問的問題，希望能幫助您了解更多
            </p>
        </div>
        
        <div class="faq-cards-container">
            <div class="faq-card">
                <div class="faq-card-header">
                    <div class="faq-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="faq-card-title">專案開發需要多長時間？</h3>
                </div>
                <div class="faq-card-body">
                    <p class="faq-card-answer">
                        專案時程會根據複雜度和功能需求而定。一般來說，簡單的網站需要 1-2 個月，
                        複雜的 SaaS 平台可能需要 6-12 個月。我們會在專案開始前提供詳細的時程規劃。
                    </p>
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-card-header">
                    <div class="faq-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="faq-card-title">你們提供哪些技術支援？</h3>
                </div>
                <div class="faq-card-body">
                    <p class="faq-card-answer">
                        我們提供完整的技術支援服務，包括系統維護、bug 修復、功能更新、
                        性能優化等。支援期限會根據專案類型而定，通常為 3-12 個月。
                    </p>
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-card-header">
                    <div class="faq-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="faq-card-title">如何確保專案品質？</h3>
                </div>
                <div class="faq-card-body">
                    <p class="faq-card-answer">
                        我們採用敏捷開發方法，定期進行代碼審查、測試和客戶回饋。
                        每個階段都會有明確的交付物和驗收標準，確保專案品質符合預期。
                    </p>
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-card-header">
                    <div class="faq-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="faq-card-title">可以修改專案需求嗎？</h3>
                </div>
                <div class="faq-card-body">
                    <p class="faq-card-answer">
                        當然可以！我們理解專案需求可能會在開發過程中有所調整。
                        我們會評估變更對時程和預算的影響，並與您協商最佳的解決方案。
                    </p>
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-card-header">
                    <div class="faq-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="faq-card-title">你們使用哪些技術？</h3>
                </div>
                <div class="faq-card-body">
                    <p class="faq-card-answer">
                        我們使用多種現代技術，包括 React、Spring Boot、Laravel、Node.js、
                        Unity 3D、Python 等。技術選型會根據專案需求來決定。
                    </p>
                </div>
            </div>
            
            <div class="faq-card">
                <div class="faq-card-header">
                    <div class="faq-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3 class="faq-card-title">如何開始合作？</h3>
                </div>
                <div class="faq-card-body">
                    <p class="faq-card-answer">
                        請透過聯絡表單或電話與我們聯繫，我們會安排一次免費的諮詢會議，
                        了解您的需求並提供初步的技術方案和報價。
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <div class="map-content">
            <h2 class="map-title">我們的辦公室</h2>
            <p class="map-description">
                歡迎預約參觀我們的辦公室，我們很樂意為您介紹我們的工作環境和團隊
            </p>
            <div class="map-container">
                <div class="map-placeholder">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>台北市信義區信義路五段7號</p>
                    <a href="#" class="btn btn-secondary">
                        <i class="fas fa-directions"></i>查看地圖
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
