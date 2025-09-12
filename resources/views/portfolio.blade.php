@extends('layouts.app')

@section('description', '查看 HopeWonderland Studio 的優秀作品案例，包括遊戲開發、SaaS 平台和代工專案的成功案例。')

@section('content')
<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">作品集</h1>
            <p class="hero-description">
                展示我們的優秀作品案例，見證我們的技術實力
            </p>
        </div>
    </div>
</section>

<!-- Portfolio Filter -->
<section class="portfolio-filter">
    <div class="container">
        <div class="filter-container">
            <div class="filter-dropdown">
                <button class="filter-dropdown-toggle" id="filter-toggle">
                    <span class="filter-selected-text">全部</span>
                    <i class="fas fa-chevron-down filter-icon"></i>
                </button>
                <div class="filter-dropdown-menu" id="filter-menu">
                    <div class="filter-option active" data-filter="all">
                        <i class="fas fa-th-large"></i>
                        <span>全部</span>
                    </div>
                    @foreach($categories as $category)
                        <div class="filter-option" data-filter="{{ $category }}">
                            <i class="fas fa-{{ $category === 'game' ? 'gamepad' : ($category === 'saas' ? 'cloud' : ($category === 'web' ? 'globe' : 'mobile-alt')) }}"></i>
                            <span>{{ $category === 'game' ? '遊戲開發' : ($category === 'saas' ? 'SaaS 平台' : ($category === 'web' ? '網站開發' : '行動應用')) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="filter-results">
                <span class="results-text">顯示 <span id="results-count">{{ $portfolios->count() }}</span> 個專案</span>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Grid -->
<section class="portfolio-section">
    <div class="container">
        @if($portfolios->count() > 0)
            <div class="portfolio-grid">
                @foreach($portfolios as $portfolio)
                    <div class="portfolio-item" data-category="{{ $portfolio->category }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="portfolio-image">
                            @if($portfolio->hasFeaturedImage())
                                <img src="{{ $portfolio->featured_image_url }}" alt="{{ $portfolio->title }}" class="portfolio-img">
                            @else
                                <div class="portfolio-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div class="portfolio-overlay">
                                <div class="portfolio-actions">
                                    @if($portfolio->project_url)
                                        <a href="{{ $portfolio->project_url }}" target="_blank" class="portfolio-link">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @endif
                                    @if($portfolio->demo_url)
                                        <a href="{{ $portfolio->demo_url }}" target="_blank" class="portfolio-link">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    @if($portfolio->github_url)
                                        <a href="{{ $portfolio->github_url }}" target="_blank" class="portfolio-link">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="portfolio-content">
                            <div class="portfolio-header">
                                <h3 class="portfolio-title">{{ $portfolio->title }}</h3>
                                <span class="portfolio-category">{{ $portfolio->category_display }}</span>
                            </div>
                            <p class="portfolio-description">{{ Str::limit($portfolio->description, 120) }}</p>
                            
                            @if($portfolio->technologies && count($portfolio->technologies) > 0)
                                <div class="portfolio-tech">
                                    @foreach(array_slice($portfolio->technologies, 0, 4) as $tech)
                                        <span class="tech-tag">{{ $tech }}</span>
                                    @endforeach
                                    @if(count($portfolio->technologies) > 4)
                                        <span class="tech-tag tech-more">+{{ count($portfolio->technologies) - 4 }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="portfolio-meta">
                                @if($portfolio->start_date)
                                    <span class="meta-item">
                                        <i class="fas fa-calendar"></i>{{ $portfolio->start_date->format('Y年') }}
                                    </span>
                                @endif
                                @if($portfolio->team_size)
                                    <span class="meta-item">
                                        <i class="fas fa-users"></i>{{ $portfolio->team_size }}人團隊
                                    </span>
                                @endif
                                @if($portfolio->duration_months)
                                    <span class="meta-item">
                                        <i class="fas fa-clock"></i>{{ $portfolio->duration_display }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="empty-title">作品集</h3>
                <p class="empty-description">我們正在準備精彩的作品案例，敬請期待！</p>
            </div>
        @endif
    </div>
</section>
@endsection