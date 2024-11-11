@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>常見問題管理</h2>
            <div>
                <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-outline-primary me-2">分類管理</a>
                <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">新增常見問題</a>
            </div>
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
                            <th style="width: 5%">ID</th>
                            <th>分類</th>
                            <th>標題</th>
                            <th>排序</th>
                            <th>狀態</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $faq)
                            <tr>
                                <td>{{ $faq->id }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $faq->category->title }}
                                    </span>
                                </td>
                                <td>{{ $faq->title }}</td>
                                <td>{{ $faq->sort_order }}</td>
                                <td>
                                    <span class="badge {{ $faq->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $faq->is_active ? '啟用' : '停用' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.faqs.edit', $faq) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST"
                                            onsubmit="return confirm('確定要刪除此常見問題嗎？');">
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
                    {{ $faqs->links() }}
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
