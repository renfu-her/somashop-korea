@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>帳號管理</h2>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">新增帳號</a>
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
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>Email</th>
                            <th>電話</th>
                            <th>狀態</th>
                            <th>最後登入時間</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->phone }}</td>
                                <td>
                                    <span class="badge bg-{{ $admin->is_active ? 'success' : 'danger' }}">
                                        {{ $admin->is_active ? '啟用' : '停用' }}
                                    </span>
                                </td>
                                <td>{{ $admin->last_login_at ?? '尚未登入' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.admins.edit', $admin) }}"
                                            class="btn btn-sm btn-outline-primary">編輯</a>
                                        @if ($admin->id !== auth()->id())
                                            <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST"
                                                onsubmit="return confirm('確定要刪除此管理者嗎？');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">刪除</button>
                                            </form>
                                        @endif
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
        });
    </script>
@endpush
