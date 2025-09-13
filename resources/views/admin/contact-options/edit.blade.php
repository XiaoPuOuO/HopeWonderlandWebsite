@extends('layouts.admin')


@section('head')
@vite(['resources/css/contact-options.css'])
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">編輯聯絡選項</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.contact-options.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> 返回列表
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6><i class="fas fa-exclamation-circle"></i> 請修正以下錯誤：</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">選項資訊</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.contact-options.update', $contactOption) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">選項類型 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">請選擇類型</option>
                                        <option value="service" {{ old('type', $contactOption->type) == 'service' ? 'selected' : '' }}>服務類型</option>
                                        <option value="budget" {{ old('type', $contactOption->type) == 'budget' ? 'selected' : '' }}>預算範圍</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">排序順序</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $contactOption->sort_order) }}" min="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">數字越小排序越靠前</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="value" class="form-label">選項值 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('value') is-invalid @enderror" 
                                   id="value" name="value" value="{{ old('value', $contactOption->value) }}" required>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">用於程式識別的內部值，建議使用英文</div>
                        </div>

                        <div class="mb-3">
                            <label for="label" class="form-label">顯示標籤 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                   id="label" name="label" value="{{ old('label', $contactOption->label) }}" required>
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">用戶看到的顯示文字</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $contactOption->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    啟用此選項
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.contact-options.index') }}" class="btn btn-secondary me-2">取消</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
