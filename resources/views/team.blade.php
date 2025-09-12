@extends('layouts.app')
@section('description', '認識 HopeWonderland Studio 的核心團隊成員，了解我們的專業背景和技術實力。')

@section('content')
<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">核心團隊</h1>
            <p class="hero-description">
                認識我們的專業團隊，每個成員都擁有豐富的技術經驗和創新思維
            </p>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        @if($teamMembers->count() > 0)
            <div class="team-grid">
                @foreach($teamMembers as $member)
                    <div class="team-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="team-avatar">
                            @if($member->hasAvatar())
                                <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="avatar-image">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="team-info">
                            <h3 class="team-name">{{ $member->name }}</h3>
                            <p class="team-position">{{ $member->position }}</p>
                            
                            @if($member->bio)
                                <p class="team-bio">{{ Str::limit($member->bio, 120) }}</p>
                            @endif
                            
                            @if($member->skills && count($member->skills) > 0)
                                <div class="team-skills" data-member-id="{{ $member->id }}">
                                    @foreach(array_slice($member->skills, 0, 4) as $skill)
                                        <span class="skill-tag">{{ $skill }}</span>
                                    @endforeach
                                    @if(count($member->skills) > 4)
                                        <span class="skill-tag skill-more" data-member-id="{{ $member->id }}">
                                            +{{ count($member->skills) - 4 }}
                                        </span>
                                        <div class="skill-tags-hidden" id="skills-{{ $member->id }}" style="display: none;">
                                            @foreach(array_slice($member->skills, 4) as $skill)
                                                <span class="skill-tag">{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            @if($member->social_links)
                                <div class="team-social">
                                    @if(isset($member->social_links['linkedin']))
                                        <a href="{{ $member->social_links['linkedin'] }}" target="_blank" class="social-link">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    @endif
                                    @if(isset($member->social_links['github']))
                                        <a href="{{ $member->social_links['github'] }}" target="_blank" class="social-link">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    @endif
                                    @if(isset($member->social_links['twitter']))
                                        <a href="{{ $member->social_links['twitter'] }}" target="_blank" class="social-link">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif
                                    @if(isset($member->social_links['website']))
                                        <a href="{{ $member->social_links['website'] }}" target="_blank" class="social-link">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                    @endif
                                    @if($member->email)
                                        <a href="mailto:{{ $member->email }}" class="social-link">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="empty-title">團隊成員</h3>
                <p class="empty-description">我們正在組建優秀的團隊，敬請期待！</p>
            </div>
        @endif
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

@push('scripts')
@vite(['resources/js/team.js'])
@endpush
@endsection