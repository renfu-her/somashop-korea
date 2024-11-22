@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>{{ $product->name }} - 規格管理</h2>
            <div>
                <a href="{{ route('admin.products.specs.create', $product->id) }}" class="btn btn-primary">新增規格</a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-secondary">返回產品</a>
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
                            <th width="10%">ID</th>
                            <th width="20%">規格名稱</th>
                            <th width="25%">規格值</th>
                            <th width="10%">價格</th>
                            <th width="10%">排序</th>
                            <th width="10%">狀態</th>
                            <th width="15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specs as $spec)
                            <tr>
                                <td>{{ $spec->id }}</td>
                                <td>{{ $spec->name }}</td>
                                <td>{{ $spec->value }}</td>
                                <td>{{ number_format($spec->price) }}</td>
                                <td>{{ $spec->sort_order }}</td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                        <input class="form-check-input toggle-active" 
                                               type="checkbox" 
                                               data-id="{{ $spec->id }}"
                                               {{ $spec->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.products.specs.edit', [$product->id, $spec->id]) }}"
                                            class="btn btn-sm btn-outline-primary">編輯</a>
                                        <form action="{{ route('admin.products.specs.destroy', [$product->id, $spec->id]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('確定要刪除此規格嗎？');">
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
                order: [[4, 'asc']], // 按排序欄位升序排序
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });

            // 處理狀態切換
            $('.toggle-active').change(function() {
                const id = $(this).data('id');
                const isActive = $(this).prop('checked');
                
                $.ajax({
                    url: "{{ route('admin.products.specs.toggle-active', ['product' => $product->id, 'spec' => ':spec']) }}".replace(':spec', id),
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
