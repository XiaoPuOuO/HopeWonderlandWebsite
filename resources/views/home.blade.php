@extends('layouts.app')

@section('description', 'HopeWonderland Studio 是專業的科技工作室，專精於遊戲開發、SaaS 服務、代工解決方案與微服務架構。')

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
                    <i class="fas fa-plus"></i>
                </div>
                <h3 class="empty-title">暫無子品牌網站</h3>
                <p class="empty-description">我們正在準備更多精彩的子品牌網站，敬請期待！</p>
                <a href="{{ route('admin.sub-brands.create') }}" 
                   class="btn btn-primary">
                    <i class="fas fa-plus"></i>添加子品牌網站
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">聯絡我們</h2>
            <p class="section-description">
                有技術需求想要實現嗎？讓我們一起打造創新的解決方案！
            </p>
        </div>
        
        <div class="contact-content">
            <div class="contact-info">
                <h3 class="contact-title">取得聯繫</h3>
                
                <div class="contact-items">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4 class="contact-label">電子郵件</h4>
                            <p class="contact-value">contact@hopewonderland.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4 class="contact-label">電話</h4>
                            <p class="contact-value">+886 2 1234 5678</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4 class="contact-label">地址</h4>
                            <p class="contact-value">台北市信義區信義路五段7號</p>
                        </div>
                    </div>
                </div>
                
                <div class="social-section">
                    <h4 class="social-title">關注我們</h4>
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
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <form class="form">
                    <div class="form-group">
                        <label for="name" class="form-label">姓名</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">電子郵件</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="service" class="form-label">服務類型</label>
                        <select id="service" name="service" class="form-control">
                            <option value="">請選擇服務類型</option>
                            <option value="game-development">遊戲開發</option>
                            <option value="saas-development">SaaS 開發</option>
                            <option value="outsourcing">代工服務</option>
                            <option value="consulting">技術諮詢</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">專案描述</label>
                        <textarea id="message" name="message" rows="4" class="form-control" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-paper-plane"></i>發送訊息
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection