@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>會員管理</h2>
            <a href="{{ route('admin.members.create') }}" class="btn btn-primary">新增會員</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>Email</th>
                            <th>電話</th>
                            <th>狀態</th>
                            <th>註冊時間</th>
                            <th>最後登入</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input status-switch"
                                            data-id="{{ $member->id }}" {{ $member->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>{{ $member->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $member->last_login_at ? $member->last_login_at->format('Y-m-d H:i') : '尚未登入' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.members.edit', $member) }}"
                                            class="btn btn-sm btn-outline-primary">編輯</a>
                                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST"
                                            onsubmit="return confirm('確定要刪除此會員嗎？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">刪除</button>
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
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });

            // 處理狀態切換
            $('.status-switch').change(function() {
                const memberId = $(this).data('id');
                const isActive = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: `/admin/members/${memberId}/toggle-status`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_active: isActive
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('會員狀態已更新');
                        } else {
                            toastr.error('更新失敗');
                        }
                    },
                    error: function() {
                        toastr.error('發生錯誤，請稍後再試');
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .form-switch {
            padding-left: 2.5em;
        }

        .form-check-input {
            cursor: pointer;
        }
    </style>
@endpush
