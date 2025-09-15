@extends('layouts.app')

@section('title', '編輯個人資料')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fas fa-edit"></i> 編輯個人資料
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
                    
                    <form method="POST" action="{{ route('user.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user"></i> 姓名
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> 電子郵件
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 更新資料
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
@endsection
