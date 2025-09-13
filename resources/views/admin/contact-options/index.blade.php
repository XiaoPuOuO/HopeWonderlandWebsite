@extends('layouts.admin')


@section('head')
@vite(['resources/css/contact-options.css', 'resources/js/contact-options.js'])
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">聯絡選項管理</h4>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- 操作按鈕 -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.contact-options.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> 新增選項
                    </a>
                </div>
                <div>
                    <button type="button" class="btn btn-success" id="bulk-activate">
                        <i class="fas fa-check"></i> 批量啟用
                    </button>
                    <button type="button" class="btn btn-warning" id="bulk-deactivate">
                        <i class="fas fa-times"></i> 批量停用
                    </button>
                    <button type="button" class="btn btn-danger" id="bulk-delete">
                        <i class="fas fa-trash"></i> 批量刪除
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 服務類型選項 -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs"></i> 服務類型選項
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="select-all-service" class="form-check-input">
                                    </th>
                                    <th>排序</th>
                                    <th>選項值</th>
                                    <th>顯示標籤</th>
                                    <th>狀態</th>
                                    <th>建立時間</th>
                                    <th width="200">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($serviceOptions as $option)
                                    <tr class="{{ !$option->is_active ? 'table-secondary' : '' }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input option-checkbox" value="{{ $option->id }}">
                                        </td>
                                        <td>{{ $option->sort_order }}</td>
                                        <td>{{ $option->value }}</td>
                                        <td>{{ $option->label }}</td>
                                        <td>
                                            @if($option->is_active)
                                                <button type="button" class="badge bg-success status-toggle" data-id="{{ $option->id }}" data-action="deactivate">啟用</button>
                                            @else
                                                <button type="button" class="badge bg-secondary status-toggle" data-id="{{ $option->id }}" data-action="activate">停用</button>
                                            @endif
                                        </td>
                                        <td>{{ $option->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.contact-options.edit', $option) }}" class="btn btn-outline-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger delete-btn" data-id="{{ $option->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="fas fa-inbox"></i> 暫無服務類型選項
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 預算範圍選項 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-dollar-sign"></i> 預算範圍選項
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="select-all-budget" class="form-check-input">
                                    </th>
                                    <th>排序</th>
                                    <th>選項值</th>
                                    <th>顯示標籤</th>
                                    <th>狀態</th>
                                    <th>建立時間</th>
                                    <th width="200">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($budgetOptions as $option)
                                    <tr class="{{ !$option->is_active ? 'table-secondary' : '' }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input option-checkbox" value="{{ $option->id }}">
                                        </td>
                                        <td>{{ $option->sort_order }}</td>
                                        <td>{{ $option->value }}</td>
                                        <td>{{ $option->label }}</td>
                                        <td>
                                            @if($option->is_active)
                                                <button type="button" class="badge bg-success status-toggle" data-id="{{ $option->id }}" data-action="deactivate">啟用</button>
                                            @else
                                                <button type="button" class="badge bg-secondary status-toggle" data-id="{{ $option->id }}" data-action="activate">停用</button>
                                            @endif
                                        </td>
                                        <td>{{ $option->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.contact-options.edit', $option) }}" class="btn btn-outline-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger delete-btn" data-id="{{ $option->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="fas fa-inbox"></i> 暫無預算範圍選項
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 批量操作確認模態框 -->
<div class="modal fade" id="bulk-modal" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulk-modal-title">確認操作</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="bulk-modal-body">
                確定要執行此操作嗎？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="confirm-bulk-action">確認操作</button>
            </div>
        </div>
    </div>
</div>
@endsection
