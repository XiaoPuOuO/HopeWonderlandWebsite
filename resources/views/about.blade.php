@extends('layouts.app')

@section('description', '了解 HopeWonderland Studio 的使命、願景和核心價值，我們是一支專業的科技團隊，致力於創造優秀的數位解決方案。')

@section('content')
<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">關於我們</h1>
            <p class="hero-description">
                我們是一支充滿熱忱的科技團隊，致力於創造優秀的數位解決方案
            </p>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="mission-section">
    <div class="container">
        <div class="mission-content">
            <div class="mission-text" data-aos="fade-right">
                <h2 class="section-title">我們的使命</h2>
                <p class="mission-description">
                    HopeWonderland Studio 成立於 2025 年，是一支充滿熱忱的新創科技團隊。
                    雖然我們是新成立的團隊，但我們擁有豐富的技術經驗和對創新的熱忱，
                    致力於為客戶提供高品質的數位解決方案，包括遊戲開發、SaaS 平台建構、
                    網站開發和微服務架構設計。
                </p>
                <p class="mission-description">
                    我們相信技術的力量能夠改變世界，透過創新的思維和專業的技術能力，
                    我們幫助企業實現數位轉型，創造更大的商業價值。作為新創公司，
                    我們更注重每個專案的品質和客戶的滿意度，用我們的熱忱和專業來彌補經驗的不足。
                </p>
            </div>
            <div class="mission-image" data-aos="fade-left">
                <div class="image-placeholder">
                    <i class="fas fa-rocket"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">我們的專業領域</h2>
            <p class="section-description">
                我們在以下領域擁有豐富的經驗和專業能力
            </p>
        </div>
        
        <div class="services-grid">
            <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <h3 class="service-title">遊戲開發</h3>
                <p class="service-description">
                    專精於 Unity 3D  開發，提供從概念設計到上線運營的完整遊戲開發服務。
                    包括多人遊戲、單機遊戲和手遊開發。
                </p>
                <ul class="service-features">
                    <li>Unity 3D 開發</li>
                    <li>多人遊戲架構</li>
                    <li>遊戲優化</li>
                </ul>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-cloud"></i>
                </div>
                <h3 class="service-title">SaaS 平台</h3>
                <p class="service-description">
                    建構可擴展的 SaaS 平台，採用微服務架構和雲端技術，
                    為企業提供穩定、高效的軟體即服務解決方案。
                </p>
                <ul class="service-features">
                    <li>微服務架構</li>
                    <li>雲端部署</li>
                    <li>API 設計</li>
                    <li>系統整合</li>
                </ul>
            </div>
            
            <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3 class="service-title">網站開發</h3>
                <p class="service-description">
                    打造現代化的網站和 Web 應用程式，注重用戶體驗和性能優化。
                    從響應式設計到後端 API 開發，提供完整的網站解決方案。
                </p>
                <ul class="service-features">
                    <li>響應式設計</li>
                    <li>前端框架</li>
                    <li>後端開發</li>
                    <li>性能優化</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">我們的價值觀</h2>
            <p class="section-description">
                這些核心價值觀指導著我們的每一個決策和行動
            </p>
        </div>
        
        <div class="values-grid">
            <div class="value-card" data-aos="fade-up" data-aos-delay="100">
                <div class="value-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="value-title">創新思維</h3>
                <p class="value-description">
                    持續探索新技術，勇於嘗試創新解決方案，為客戶創造獨特價值
                </p>
            </div>
            
            <div class="value-card" data-aos="fade-up" data-aos-delay="200">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="value-title">團隊合作</h3>
                <p class="value-description">
                    重視團隊協作，相信集體智慧的力量，共同追求卓越成果
                </p>
            </div>
            
            <div class="value-card" data-aos="fade-up" data-aos-delay="300">
                <div class="value-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="value-title">品質至上</h3>
                <p class="value-description">
                    對代碼品質和產品品質有著極高要求，確保每個項目都達到最高標準
                </p>
            </div>
            
            <div class="value-card" data-aos="fade-up" data-aos-delay="400">
                <div class="value-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="value-title">持續學習</h3>
                <p class="value-description">
                    保持學習熱忱，不斷提升技術能力，跟上科技發展的腳步
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">我們的開發流程</h2>
            <p class="section-description">
                採用敏捷開發方法，確保專案按時交付並達到最高品質標準
            </p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step" data-aos="fade-up" data-aos-delay="100">
                <div class="step-number">01</div>
                <div class="step-content">
                    <h3 class="step-title">需求分析</h3>
                    <p class="step-description">
                        深入了解客戶需求，分析技術可行性，制定專案規劃
                    </p>
                </div>
            </div>
            
            <div class="process-step" data-aos="fade-up" data-aos-delay="200">
                <div class="step-number">02</div>
                <div class="step-content">
                    <h3 class="step-title">設計階段</h3>
                    <p class="step-description">
                        進行系統架構設計、UI/UX 設計，確保產品符合用戶需求
                    </p>
                </div>
            </div>
            
            <div class="process-step" data-aos="fade-up" data-aos-delay="300">
                <div class="step-number">03</div>
                <div class="step-content">
                    <h3 class="step-title">開發實現</h3>
                    <p class="step-description">
                        採用敏捷開發方法，分階段實現功能，確保代碼品質
                    </p>
                </div>
            </div>
            
            <div class="process-step" data-aos="fade-up" data-aos-delay="400">
                <div class="step-number">04</div>
                <div class="step-content">
                    <h3 class="step-title">測試部署</h3>
                    <p class="step-description">
                        進行全面測試，確保系統穩定，並協助客戶完成部署上線
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection