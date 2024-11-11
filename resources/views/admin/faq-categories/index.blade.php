@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>常見問題分類管理</h2>
            <a href="{{ route('admin.faq-categories.create') }}" class="btn btn-primary">新增分類</a>
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
                            <th style="width: 5%">ID</th>
                            <th>分類名稱</th>
                            <th>問題數量</th>
                            <th>排序</th>
                            <th>狀態</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->title }}</td>
                                <td>{{ $category->faqs_count }}</td>
                                <td>{{ $category->sort_order }}</td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $category->is_active ? '啟用' : '停用' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.faq-categories.edit', $category) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.faq-categories.destroy', $category) }}" 
                                            method="POST"
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
                },
                responsive: true,
                ordering: false,
            });
        });
    </script>
@endpush 