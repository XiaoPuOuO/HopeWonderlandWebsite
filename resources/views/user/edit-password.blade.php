@extends('layouts.app')

@section('title', '修改密碼')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fas fa-key"></i> 修改密碼
                    </h2>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('user.update-password') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-lock"></i> 目前密碼
                            </label>
                            <input type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-key"></i> 新密碼
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> 密碼至少需要8個字符
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-double"></i> 確認新密碼
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                        </div>
                        
                        <div class="password-strength mb-3">
                            <div class="strength-label">密碼強度：</div>
                            <div class="strength-bar">
                                <div class="strength-fill" id="strength-fill"></div>
                            </div>
                            <div class="strength-text" id="strength-text">請輸入密碼</div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 更新密碼
                            </button>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> 返回
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.card-header {
    background: var(--bg-primary);
    border-bottom: 1px solid var(--border-color);
    padding: 1.5rem;
}

.card-header h2 {
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-control {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    padding: 0.75rem 1rem;
    transition: all var(--transition-normal);
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb), 0.25);
    background: var(--bg-secondary);
}

.form-control.is-invalid {
    border-color: var(--danger-color);
}

.invalid-feedback {
    color: var(--danger-color);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-text {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.password-strength {
    margin-top: 1rem;
}

.strength-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.strength-bar {
    height: 4px;
    background: var(--bg-primary);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-text {
    font-size: 0.875rem;
    font-weight: 500;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-md);
    font-weight: 500;
    transition: all var(--transition-normal);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: var(--primary-color);
    color: var(--text-white);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--bg-secondary);
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        
        updateStrengthDisplay(strength);
    });
    
    function calculatePasswordStrength(password) {
        let score = 0;
        let feedback = [];
        
        if (password.length >= 8) score += 1;
        else feedback.push('至少8個字符');
        
        if (/[a-z]/.test(password)) score += 1;
        else feedback.push('包含小寫字母');
        
        if (/[A-Z]/.test(password)) score += 1;
        else feedback.push('包含大寫字母');
        
        if (/[0-9]/.test(password)) score += 1;
        else feedback.push('包含數字');
        
        if (/[^A-Za-z0-9]/.test(password)) score += 1;
        else feedback.push('包含特殊字符');
        
        return { score, feedback };
    }
    
    function updateStrengthDisplay(strength) {
        const { score, feedback } = strength;
        const percentage = (score / 5) * 100;
        
        strengthFill.style.width = percentage + '%';
        
        if (score === 0) {
            strengthFill.style.background = 'transparent';
            strengthText.textContent = '請輸入密碼';
            strengthText.style.color = 'var(--text-secondary)';
        } else if (score <= 2) {
            strengthFill.style.background = 'var(--danger-color)';
            strengthText.textContent = '弱 - ' + feedback.join('、');
            strengthText.style.color = 'var(--danger-color)';
        } else if (score <= 3) {
            strengthFill.style.background = 'var(--warning-color)';
            strengthText.textContent = '中等 - ' + feedback.join('、');
            strengthText.style.color = 'var(--warning-color)';
        } else if (score <= 4) {
            strengthFill.style.background = 'var(--info-color)';
            strengthText.textContent = '良好 - ' + feedback.join('、');
            strengthText.style.color = 'var(--info-color)';
        } else {
            strengthFill.style.background = 'var(--success-color)';
            strengthText.textContent = '強 - 密碼強度很好！';
            strengthText.style.color = 'var(--success-color)';
        }
    }
});
</script>
@endsection
