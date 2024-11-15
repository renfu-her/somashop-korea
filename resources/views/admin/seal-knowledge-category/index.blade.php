@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>印章知識分類管理</h2>
            <a href="{{ route('admin.seal-knowledge-category.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>新增分類
            </a>
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
                            <th style="width: 25%">分類名稱</th>
                            <th style="width: 15%">文章數量</th>
                            <th style="width: 15%">更新時間</th>
                            <th style="width: 10%">排序</th>
                            <th style="width: 10%">狀態</th>
                            <th style="width: 20%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->seal_knowledges_count }}</td>
                                <td>{{ $category->updated_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm sort-input" 
                                           value="{{ $category->sort }}" 
                                           data-id="{{ $category->id }}"
                                           style="width: 70px">
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input status-switch" 
                                               data-id="{{ $category->id }}"
                                               {{ $category->status ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.seal-knowledge-category.edit', $category) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.seal-knowledge-category.destroy', $category) }}"
                                              method="POST" 
                                              onsubmit="return confirm('確定要刪除此分類嗎？如果分類下有文章將無法刪除');">
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/2.1.8/i18n/zh-HANT.json"
                },
                responsive: true,
                order: [
                    [4, 'asc']  // 預設按排序欄位升序排序
                ],
                columnDefs: [{
                    targets: -1, // 最後一欄（操作欄）
                    orderable: false // 禁用排序
                }]
            });

            // 排序功能
            $('.sort-input').change(function() {
                let id = $(this).data('id');
                let sort = $(this).val();
                
                $.ajax({
                    url: '{{ route("admin.seal-knowledge-category.update-sort") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: [{id: id, sort: sort}]
                    },
                    success: function(response) {
                        toastr.success('排序更新成功');
                    },
                    error: function(xhr) {
                        toastr.error('排序更新失敗');
                    }
                });
            });

            // 狀態切換
            $('.status-switch').change(function() {
                let id = $(this).data('id');
                
                $.ajax({
                    url: `/admin/seal-knowledge-category/${id}/toggle-status`,
                    method: 'POST',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(response) {
                        toastr.success('狀態更新成功');
                    },
                    error: function(xhr) {
                        toastr.error('狀態更新失敗');
                    }
                });
            });
        });
    </script>
@endpush 