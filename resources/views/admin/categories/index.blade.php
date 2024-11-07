@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>分類管理</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">新增分類</a>
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
                            <th>名稱</th>
                            <th>Slug</th>
                            <th>筆記數量</th>
                            <th>創建時間</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->notes_count }}</td>
                                <td>{{ $category->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('確定要刪除此分類嗎？');">
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

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
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
                }
            });
        });
    </script>
@endpush
