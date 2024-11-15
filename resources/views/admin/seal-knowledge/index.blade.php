@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>認識印章管理</h2>
            <div class="d-flex align-items-center">
                <select id="categoryFilter" class="form-select me-2" style="width: auto;">
                    <option value="">所有分類</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('admin.seal-knowledge-category.index') }}" class="btn btn-outline-primary me-2">分類管理</a>
                <a href="{{ route('admin.seal-knowledge.create') }}" class="btn btn-primary">新增文章</a>
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
                        @foreach ($knowledges as $knowledge)
                            <tr>
                                <td>{{ $knowledge->id }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $knowledge->category->name }}
                                    </span>
                                </td>
                                <td>{{ $knowledge->title }}</td>
                                <td>{{ $knowledge->sort }}</td>
                                <td>
                                    <span class="badge {{ $knowledge->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $knowledge->status ? '啟用' : '停用' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.seal-knowledge.edit', $knowledge) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
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
            const table = $('#dataTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/2.1.8/i18n/zh-HANT.json"
                },
                responsive: true,
                ordering: false,
            });

            $('#categoryFilter').change(function() {
                const categoryId = $(this).val();
                window.location.href = '{{ route("admin.seal-knowledge.index") }}' + 
                    (categoryId ? '?category_id=' + categoryId : '');
            });
        });
    </script>
@endpush
