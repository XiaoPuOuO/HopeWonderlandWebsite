@extends('layouts.app')

@section('title', '會員登入')
@section('description', 'HopeWonderland Studio 會員登入')

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/icon.png') }}" alt="HopeWonderland Studio" class="login-logo">
            <h1 class="login-title">會員登入</h1>
            <p class="login-subtitle">HopeWonderland Studio</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            
            @if ($errors->any())
                <div class="login-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i>
                    電子郵件
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       class="form-input @error('email') error @enderror"
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       placeholder="請輸入您的電子郵件">
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i>
                    密碼
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-input @error('password') error @enderror"
                       required
                       placeholder="請輸入您的密碼">
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-checkbox">
                <label for="remember" class="form-checkbox-label">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember" 
                           class="form-checkbox-input"
                           {{ old('remember') ? 'checked' : '' }}>
                    <span class="checkbox-custom"></span>
                    <span class="checkbox-text">記住我</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-login">
                <i class="fas fa-sign-in-alt"></i>
                登入
            </button>
        </form>

        <div class="login-footer">
            <p class="login-footer-text">還沒有帳號？</p>
            <a href="{{ route('register') }}" class="login-link">
                <i class="fas fa-user-plus"></i>
                立即註冊
            </a>
        </div>
    </div>
</div>

<style>
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    transition: background 0.3s ease;
}

/* 暗模式背景 */
[data-theme="dark"] .login-container {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
}

.login-card {
    background: var(--card-bg);
    border-radius: 1rem;
    padding: 3rem;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

[data-theme="dark"] .login-card {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    border-color: var(--border-dark);
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-logo {
    width: 4rem;
    height: 4rem;
    margin-bottom: 1rem;
    border-radius: 0.5rem;
}

.login-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.login-subtitle {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.login-form {
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-label i {
    margin-right: 0.5rem;
    color: var(--primary-color);
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 0.5rem;
    background: var(--input-bg);
    color: var(--text-primary);
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
}

.form-input.error {
    border-color: var(--error-color);
}

.form-error {
    display: block;
    color: var(--error-color);
    font-size: 0.8rem;
    margin-top: 0.25rem;
}

.form-checkbox {
    margin-bottom: 1.5rem;
}

.form-checkbox-label {
    display: flex;
    align-items: center;
    color: var(--text-secondary);
    font-size: 0.9rem;
    cursor: pointer;
    user-select: none;
}

.form-checkbox-input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkbox-custom {
    position: relative;
    display: inline-block;
    width: 18px;
    height: 18px;
    background: var(--input-bg);
    border: 2px solid var(--border-color);
    border-radius: 4px;
    margin-right: 8px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.checkbox-custom::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid var(--text-white);
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.form-checkbox-input:checked + .checkbox-custom {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.form-checkbox-input:checked + .checkbox-custom::after {
    opacity: 1;
}

.form-checkbox-input:focus + .checkbox-custom {
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
    border-color: var(--primary-color);
}

.checkbox-text {
    line-height: 1;
}

.btn-login {
    width: 100%;
    padding: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.login-error {
    background: var(--error-bg);
    color: var(--error-color);
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.login-footer {
    text-align: center;
}

.login-footer-text {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.login-link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s ease;
    font-weight: 500;
}

.login-link:hover {
    color: var(--primary-hover);
}

@media (max-width: 480px) {
    .login-container {
        padding: 1rem;
    }
    
    .login-card {
        padding: 2rem;
    }
}
</style>
@endsection