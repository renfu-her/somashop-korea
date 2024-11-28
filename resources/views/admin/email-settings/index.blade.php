@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>郵件設定</h2>
            <a href="{{ route('admin.email-settings.create') }}" class="btn btn-primary">新增郵件</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-responsive" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th>名稱</th>
                            <th>郵箱</th>
                            <th>狀態</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emailSettings as $setting)
                            <tr>
                                <td>{{ $setting->id }}</td>
                                <td>{{ $setting->name }}</td>
                                <td>{{ $setting->email }}</td>
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                        <input class="form-check-input toggle-active" 
                                               type="checkbox" 
                                               data-id="{{ $setting->id }}"
                                               {{ $setting->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.email-settings.edit', $setting) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.email-settings.destroy', $setting) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('確定要刪除此郵件設定嗎？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                刪除
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .btn-group {
        display: flex;
        gap: 5px;
    }
    .table td {
        vertical-align: middle;
    }
    .form-switch {
        padding-left: 2.5em;
    }
    .form-check-input {
        cursor: pointer;
        width: 3em;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/2.1.8/i18n/zh-HANT.json"
            },
            responsive: true,
            order: [[0, 'desc']],
            columnDefs: [{
                targets: -1,
                orderable: false
            }]
        });

        $('.toggle-active').change(function() {
            const id = $(this).data('id');
            const isActive = $(this).prop('checked');
            
            $.ajax({
                url: `/admin/email-settings/${id}/toggle-active`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_active: isActive
                },
                success: function(response) {
                    toastr.success('狀態更新成功');
                },
                error: function() {
                    toastr.error('狀態更新失敗');
                    // 如果失敗，恢復開關狀態
                    $(this).prop('checked', !isActive);
                }
            });
        });
    });
</script>
@endpush 