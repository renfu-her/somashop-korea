{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>產品管理</h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">新增產品</a>
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
                            <th>圖片</th>
                            <th>名稱</th>
                            <th>價格</th>
                            <th>庫存</th>
                            <th>分類</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if ($product->images()->where('is_primary', true)->first())
                                        <img src="{{ asset('storage/products/' . $product->id . '/' . $product->images()->where('is_primary', true)->first()->image_path) }}"
                                            alt="{{ $product->name }}" width="50">
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->category->name ?? '未分類' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('確定要刪除此產品嗎？');">
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
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table td img,
        .jsgrid .jsgrid-table td img {
            width: 100px !important;
            height: 100px !important;
            border-radius: 0 !important;
            object-fit: cover;
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
                order: [
                    [0, 'desc']
                ], // 預設按 ID 降序排序
                columnDefs: [{
                    targets: -1, // 最後一欄（操作欄）
                    orderable: false // 禁用排序
                }]
            });
        });
    </script>
@endpush
