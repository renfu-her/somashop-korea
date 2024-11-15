@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>認識印章管理</h2>
            <div>
                <a href="{{ route('admin.seal-knowledge-category.index') }}" class="btn btn-info me-2">
                    <i class="fas fa-folder me-1"></i>分類管理
                </a>
                <a href="{{ route('admin.seal-knowledge.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>新增文章
                </a>
            </div>
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
                            <th style="width: 30%">標題</th>
                            <th style="width: 15%">分類</th>
                            <th style="width: 15%">更新時間</th>
                            <th style="width: 10%">排序</th>
                            <th style="width: 10%">狀態</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($knowledges as $knowledge)
                            <tr>
                                <td>{{ $knowledge->id }}</td>
                                <td>{{ $knowledge->title }}</td>
                                <td>{{ $knowledge->category->name }}</td>
                                <td>{{ $knowledge->updated_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm sort-input"
                                        value="{{ $knowledge->sort }}" data-id="{{ $knowledge->id }}" style="width: 70px">
                                </td>
                                <td>
                                    <span class="badge bg-{{ $knowledge->status ? 'success' : 'danger' }}">
                                        {{ $knowledge->status ? '啟用' : '停用' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.seal-knowledge.edit', $knowledge) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <a href="{{ route('admin.seal-knowledge.show', $knowledge) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            預覽
                                        </a>
                                        <form action="{{ route('admin.seal-knowledge.destroy', $knowledge) }}"
                                            method="POST" onsubmit="return confirm('確定要刪除此文章嗎？');">
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
            // DataTables 初始化
            $('#dataTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/2.1.8/i18n/zh-HANT.json"
                },
                responsive: true,
                order: [
                    [4, 'asc'] // 預設按排序欄位升序排序
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
                    url: '{{ route('admin.seal-knowledge.update-sort') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: [{
                            id: id,
                            sort: sort
                        }]
                    },
                    success: function(response) {
                        toastr.success('排序更新成功');
                    },
                    error: function(xhr) {
                        toastr.error('排序更新失敗');
                    }
                });
            });
        });
    </script>
@endpush
