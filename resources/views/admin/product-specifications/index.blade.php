@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $product->name }} - 規格管理</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.products.specifications.create', $product->id) }}"
                                class="btn btn-primary btn-sm">
                                新增規格
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>規格名稱</th>
                                    <th>排序</th>
                                    <th>狀態</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($specifications as $spec)
                                    <tr>
                                        <td>{{ $spec->id }}</td>
                                        <td>{{ $spec->name }}</td>
                                        <td>{{ $spec->sort_order }}</td>
                                        <td>{!! $spec->is_active
                                            ? '<span class="badge badge-success">啟用</span>'
                                            : '<span class="badge badge-danger">停用</span>' !!}</td>
                                        <td>
                                            <a href="{{ route('admin.products.specifications.edit', [$product->id, $spec->id]) }}"
                                                class="btn btn-sm btn-info">編輯</a>
                                            <form
                                                action="{{ route('admin.products.specifications.destroy', [$product->id, $spec->id]) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('確定要刪除嗎？')">刪除</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
