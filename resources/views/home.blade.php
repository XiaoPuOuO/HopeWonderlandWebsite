@extends('layouts.app')

@section('description', 'HopeWonderland Studio 是專業的科技工作室，專精於遊戲開發、SaaS 服務、代工解決方案與微服務架構。')

@section('head')
    @vite(['resources/css/contact-form.css', 'resources/js/home.js'])
@endsection

@section('content')
<!-- Hero Section -->
<section class="gradient-bg hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-icon">
                <img src="{{ asset('images/icon.png') }}" alt="HopeWonderland Studio" class="floating-animation">
            </div>
            
            <h1 class="hero-title">
                HopeWonderland
                <span class="hero-subtitle">Studio</span>
            </h1>
            
            <p class="hero-description">
                專業科技工作室，專精於遊戲開發、SaaS 服務與代工解決方案
            </p>
            
            <div class="hero-buttons">
                <a href="#brands" class="btn btn-primary btn-large">
                    <i class="fas fa-rocket"></i>探索我們的服務
                </a>
                <a href="#about" class="btn btn-secondary btn-large">
                    <i class="fas fa-code"></i>了解更多
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="about" class="services-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">我們的專業領域</h2>
            <p class="section-description">
                從遊戲開發到企業級 SaaS 解決方案，我們提供全方位的科技服務
            </p>
        </div>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <h3 class="service-title">遊戲開發</h3>
                <p class="service-description">
                    線上多人遊戲、單機遊戲開發，從概念設計到上線運營的完整解決方案
                </p>
                <ul class="service-features">
                    <li>多人線上遊戲</li>
                    <li>單機遊戲開發</li>
                    <li>遊戲代工服務</li>
                    <li>遊戲引擎優化</li>
                </ul>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-cloud"></i>
                </div>
                <h3 class="service-title">SaaS 服務</h3>
                <p class="service-description">
                    企業級 SaaS 平台開發，提供可擴展的雲端解決方案
                </p>
                <ul class="service-features">
                    <li>微服務架構</li>
                    <li>雲端部署</li>
                    <li>API 開發</li>
                    <li>數據分析平台</li>
                </ul>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3 class="service-title">代工服務</h3>
                <p class="service-description">
                    專業的代工開發服務，協助客戶實現技術願景
                </p>
                <ul class="service-features">
                    <li>網站代工</li>
                    <li>應用程式開發</li>
                    <li>系統整合</li>
                    <li>技術諮詢</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Sub Brands Section -->
<section id="brands" class="brands-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">我們的子品牌網站</h2>
            <p class="section-description">
                探索我們精心打造的子品牌網站，每個品牌都專注於不同的技術領域
            </p>
        </div>
        
        @if($subBrands->count() > 0)
            <div class="brands-grid">
                @foreach($subBrands as $subBrand)
                    <div class="brand-card">
                        <div class="brand-header">
                            @if($subBrand->logo)
                                <img src="{{ $subBrand->logo_url }}" alt="{{ $subBrand->name }}" class="brand-logo">
                            @else
                                <div class="brand-icon">
                                    <i class="fas fa-code"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="brand-content">
                            <h3 class="brand-name">{{ $subBrand->name }}</h3>
                            
                            @if($subBrand->description)
                                <p class="brand-description">{{ $subBrand->description }}</p>
                            @endif
                            
                            @if($subBrand->tags && count($subBrand->tags) > 0)
                                <div class="brand-tags">
                                    @foreach($subBrand->tags as $tag)
                                        <span class="tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="brand-actions">
                                @if($subBrand->website_url)
                                    <a href="{{ $subBrand->website_url }}" target="_blank" 
                                       class="btn btn-primary btn-small">
                                        <i class="fas fa-external-link-alt"></i>訪問官網
                                    </a>
                                @else
                                    <span class="no-link">官網連結待設定</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3 class="empty-title">暫無子品牌網站</h3>
                <p class="empty-description">我們正在準備更多精彩的子品牌網站，敬請期待！</p>
            </div>
        @endif
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
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
                            <a href="mailto:hopewonderlandteam@gmail.com" class="method-link">
                                hopewonderlandteam@gmail.com
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="method-content">
                            <h3 class="method-title">電話</h3>
                            <p class="method-description">週一至週五 12:00-22:00</p>
                            <a href="tel:+886979511816" class="method-link">
                                +886 0979 511 816
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="method-content">
                            <h3 class="method-title">服務區域</h3>
                            <p class="method-description">主要服務台北地區，其他地區可透過線上會議討論</p>
                            <span class="method-link">
                                台北市中山區
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
                <form class="form" id="home-contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="home-name" class="form-label">姓名 *</label>
                            <input type="text" id="home-name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="home-email" class="form-label">電子郵件 *</label>
                            <input type="email" id="home-email" name="email" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="home-company" class="form-label">公司名稱</label>
                            <input type="text" id="home-company" name="company" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="home-phone" class="form-label">電話</label>
                            <input type="tel" id="home-phone" name="phone" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="home-service" class="form-label">服務類型 *</label>
                        <select id="home-service" name="service" class="form-control" required>
                            <option value="">請選擇服務類型</option>
                            @foreach($serviceOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="home-budget" class="form-label">預算範圍</label>
                        <select id="home-budget" name="budget" class="form-control">
                            <option value="">請選擇預算範圍</option>
                            @foreach($budgetOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="home-timeline" class="form-label">專案時程</label>
                        <select id="home-timeline" name="timeline" class="form-control">
                            <option value="">請選擇專案時程</option>
                            <option value="urgent">緊急（1個月內）</option>
                            <option value="fast">快速（1-3個月）</option>
                            <option value="normal">正常（3-6個月）</option>
                            <option value="flexible">彈性（6個月以上）</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="home-message" class="form-label">專案描述 *</label>
                        <textarea id="home-message" name="message" rows="5" class="form-control" 
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
                <div id="home-message-alert" class="alert" style="display: none; margin-top: 20px;">
                    <span id="home-message-text"></span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection