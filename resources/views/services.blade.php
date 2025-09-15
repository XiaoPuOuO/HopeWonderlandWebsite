@extends('layouts.app')

@section('description', '了解 HopeWonderland Studio 提供的專業服務，包括遊戲開發、SaaS 平台開發、代工服務和技術諮詢。')

@section('content')
<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">我們的服務</h1>
            <p class="hero-description">
                提供全方位的科技解決方案，滿足您的各種技術需求
            </p>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="services-overview">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">服務項目</h2>
            <p class="section-description">
                我們提供多種專業服務，從遊戲開發到企業級 SaaS 解決方案
            </p>
        </div>
        
        <div class="services-grid">
            <!-- Game Development -->
            <div class="service-detail-card">
                <div class="service-header">
                    <div class="service-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h3 class="service-title">遊戲開發</h3>
                    <p class="service-subtitle">專業遊戲開發解決方案</p>
                </div>
                
                <div class="service-content">
                    <p class="service-description">
                        我們專精於各種類型的遊戲開發，從概念設計到上線運營提供完整解決方案。
                        無論是多人線上遊戲還是單機遊戲，我們都能為您打造出色的遊戲體驗。
                    </p>
                    
                    <div class="service-features">
                        <h4 class="features-title">服務內容</h4>
                        <ul class="features-list">
                            <li><i class="fas fa-check"></i>多人線上遊戲開發</li>
                            <li><i class="fas fa-check"></i>單機遊戲開發</li>
                            <li><i class="fas fa-check"></i>手機遊戲開發</li>
                            <li><i class="fas fa-check"></i>遊戲代工服務</li>
                            <li><i class="fas fa-check"></i>遊戲引擎優化</li>
                            <li><i class="fas fa-check"></i>遊戲伺服器架構</li>
                        </ul>
                    </div>
                    
                    <div class="service-tech">
                        <h4 class="tech-title">技術棧</h4>
                        <div class="tech-tags">
                            <span class="tech-tag">Unity 3D</span>
                            <span class="tech-tag">C#</span>
                            <span class="tech-tag">C++</span>
                            <span class="tech-tag">Node.js</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-footer">
                    <a href="#contact" class="btn btn-primary">
                        <i class="fas fa-envelope"></i>諮詢服務
                    </a>
                </div>
            </div>
            
            <!-- SaaS Development -->
            <div class="service-detail-card">
                <div class="service-header">
                    <div class="service-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3 class="service-title">SaaS 平台開發</h3>
                    <p class="service-subtitle">企業級 SaaS 解決方案</p>
                </div>
                
                <div class="service-content">
                    <p class="service-description">
                        專精於企業級 SaaS 平台開發，提供可擴展的雲端解決方案。
                        我們採用微服務架構，確保系統的穩定性和可擴展性。
                    </p>
                    
                    <div class="service-features">
                        <h4 class="features-title">服務內容</h4>
                        <ul class="features-list">
                            <li><i class="fas fa-check"></i>微服務架構設計</li>
                            <li><i class="fas fa-check"></i>雲端部署與管理</li>
                            <li><i class="fas fa-check"></i>API 開發與整合</li>
                            <li><i class="fas fa-check"></i>數據分析平台</li>
                            <li><i class="fas fa-check"></i>用戶管理系統</li>
                            <li><i class="fas fa-check"></i>支付系統整合</li>
                        </ul>
                    </div>
                    
                    <div class="service-tech">
                        <h4 class="tech-title">技術棧</h4>
                        <div class="tech-tags">
                            <span class="tech-tag">Docker</span>
                            <span class="tech-tag">AWS</span>
                            <span class="tech-tag">React</span>
                            <span class="tech-tag">Node.js</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-footer">
                    <a href="#contact" class="btn btn-primary">
                        <i class="fas fa-envelope"></i>諮詢服務
                    </a>
                </div>
            </div>
            
            <!-- Outsourcing -->
            <div class="service-detail-card">
                <div class="service-header">
                    <div class="service-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="service-title">代工服務</h3>
                    <p class="service-subtitle">專業代工開發服務</p>
                </div>
                
                <div class="service-content">
                    <p class="service-description">
                        提供專業的代工開發服務，協助客戶實現技術願景。
                        我們擁有豐富的專案經驗，能夠快速理解需求並提供優質的解決方案。
                    </p>
                    
                    <div class="service-features">
                        <h4 class="features-title">服務內容</h4>
                        <ul class="features-list">
                            <li><i class="fas fa-check"></i>網站代工開發</li>
                            <li><i class="fas fa-check"></i>應用程式開發</li>
                            <li><i class="fas fa-check"></i>系統整合服務</li>
                            <li><i class="fas fa-check"></i>技術諮詢服務</li>
                            <li><i class="fas fa-check"></i>維護與支援</li>
                            <li><i class="fas fa-check"></i>技術轉移</li>
                        </ul>
                    </div>
                    
                    <div class="service-tech">
                        <h4 class="tech-title">技術棧</h4>
                        <div class="tech-tags">
                            <span class="tech-tag">Laravel</span>
                            <span class="tech-tag">React</span>
                            <span class="tech-tag">Python</span>
                            <span class="tech-tag">MySQL</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-footer">
                    <a href="#contact" class="btn btn-primary">
                        <i class="fas fa-envelope"></i>諮詢服務
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">服務流程</h2>
            <p class="section-description">
                我們採用標準化的服務流程，確保每個專案都能順利完成
            </p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step" data-step="1">
                <div class="step-number">01</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="step-title">需求諮詢</h3>
                    <p class="step-description">
                        深入了解您的需求，提供專業建議和技術方案
                    </p>
                    <div class="step-details">
                        <ul class="step-features">
                            <li>需求分析與評估</li>
                            <li>技術可行性研究</li>
                            <li>初步方案設計</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="process-step" data-step="2">
                <div class="step-number">02</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3 class="step-title">專案規劃</h3>
                    <p class="step-description">
                        制定詳細的專案計劃，包括時程、預算和技術規格
                    </p>
                    <div class="step-details">
                        <ul class="step-features">
                            <li>專案時程規劃</li>
                            <li>預算評估與報價</li>
                            <li>技術架構設計</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="process-step" data-step="3">
                <div class="step-number">03</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="step-title">開發實作</h3>
                    <p class="step-description">
                        採用敏捷開發方法，確保品質和進度，定期回報進度
                    </p>
                    <div class="step-details">
                        <ul class="step-features">
                            <li>敏捷開發流程</li>
                            <li>定期進度回報</li>
                            <li>品質控制與測試</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="process-step" data-step="4">
                <div class="step-number">04</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="step-title">交付上線</h3>
                    <p class="step-description">
                        完成測試和優化，交付最終產品，提供後續技術支援
                    </p>
                    <div class="step-details">
                        <ul class="step-features">
                            <li>最終測試與優化</li>
                            <li>產品交付與部署</li>
                            <li>後續技術支援</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="process-summary">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="summary-content">
                    <h4 class="summary-title">平均專案時程</h4>
                    <p class="summary-value">2-8 週</p>
                </div>
            </div>
            
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="summary-content">
                    <h4 class="summary-title">專案團隊</h4>
                    <p class="summary-value">專業團隊</p>
                </div>
            </div>
            
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <div class="summary-content">
                    <h4 class="summary-title">技術專精</h4>
                    <p class="summary-value">5+ 年</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@vite(['resources/js/process.js'])
@endpush
