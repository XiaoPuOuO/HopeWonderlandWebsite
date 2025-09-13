@extends('layouts.admin')


@section('head')
@vite(['resources/css/contact-options.css'])
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">新增聯絡選項</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.contact-options.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> 返回列表
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">選項資訊</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.contact-options.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">選項類型 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">請選擇類型</option>
                                        <option value="service" {{ old('type') == 'service' ? 'selected' : '' }}>服務類型</option>
                                        <option value="budget" {{ old('type') == 'budget' ? 'selected' : '' }}>預算範圍</option>
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
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
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
                                   id="value" name="value" value="{{ old('value') }}" required>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">用於程式識別的內部值，建議使用英文</div>
                        </div>

                        <div class="mb-3">
                            <label for="label" class="form-label">顯示標籤 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                   id="label" name="label" value="{{ old('label') }}" required>
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">用戶看到的顯示文字</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.contact-options.index') }}" class="btn btn-secondary me-2">取消</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 儲存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">說明</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> 選項類型說明</h6>
                        <ul class="mb-0">
                            <li><strong>服務類型：</strong>用於聯絡表單的服務選擇下拉選單</li>
                            <li><strong>預算範圍：</strong>用於聯絡表單的預算範圍下拉選單</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle"></i> 注意事項</h6>
                        <ul class="mb-0">
                            <li>選項值必須唯一，不能重複</li>
                            <li>排序數字越小，顯示順序越靠前</li>
                            <li>新增後預設為啟用狀態</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
