@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>關於我們管理</h2>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">新增文章</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-responsive" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th>標題</th>
                            <th>排序</th>
                            <th>狀態</th>
                            <th>創建時間</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    <input type="number" 
                                           class="form-control form-control-sm sort-order" 
                                           data-id="{{ $post->id }}" 
                                           value="{{ $post->sort_order }}" 
                                           style="width: 80px">
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-active" 
                                               type="checkbox" 
                                               data-id="{{ $post->id }}"
                                               {{ $post->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>{{ $post->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.posts.edit', $post) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                            onsubmit="return confirm('確定要刪除此文章嗎？');">
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
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: [-1, -3],
                    orderable: false
                }]
            });

            // 處理排序更新
            $('.sort-order').change(function() {
                const id = $(this).data('id');
                const sortOrder = $(this).val();
                
                $.ajax({
                    url: `/admin/posts/${id}/sort`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        sort_order: sortOrder
                    },
                    success: function(response) {
                        toastr.success('排序更新成功');
                    },
                    error: function() {
                        toastr.error('排序更新失敗');
                    }
                });
            });

            // 處理狀態切換
            $('.toggle-active').change(function() {
                const id = $(this).data('id');
                const isActive = $(this).prop('checked');
                
                $.ajax({
                    url: `/admin/posts/${id}/toggle-active`,
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
                    }
                });
            });
        });
    </script>
@endpush 