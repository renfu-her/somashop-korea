@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>活動管理</h2>
            <a href="{{ route('admin.activities.create') }}" class="btn btn-primary">新增活動</a>
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
                            <th>標題</th>
                            <th>副標題</th>
                            <th style="width: 10%">排序</th>
                            <th style="width: 10%">狀態</th>
                            {{-- <th>日期</th> --}}
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $activity->id }}</td>
                                <td>
                                    @if ($activity->image)
                                        <img src="{{ asset('storage/activities/' . $activity->id . '/' . $activity->image) }}"
                                            alt="{{ $activity->title }}" class="activity-image">
                                    @endif
                                </td>
                                <td>{{ $activity->title }}</td>
                                <td>{{ $activity->subtitle }}</td>
                                <td class="text-center">
                                    {{ $activity->sort_order }}
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                        <input class="form-check-input toggle-active" 
                                               type="checkbox" 
                                               data-id="{{ $activity->id }}"
                                               {{ $activity->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                {{-- <td>{{ $activity->date->format('Y-m-d') }}</td> --}}
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.activities.edit', $activity) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST"
                                            onsubmit="return confirm('確定要刪除此活動嗎？');">
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

@push('styles')
    <style>
        .table td img.activity-image {
            width: 100px !important;
            height: 100px !important;
            border-radius: 0 !important;
            object-fit: cover;
        }

        /* DataTables 響應式調整 */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* 按鈕組樣式 */
        .btn-group {
            display: flex;
            gap: 5px;
        }

        /* 表格內容垂直置中 */
        .table td {
            vertical-align: middle;
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
                    [4, 'asc']
                ], // 預設按排序降序排序
                columnDefs: [{
                    targets: -1, // 最後一欄（操作欄）
                    orderable: false // 禁用排序
                }]
            });
        });

        // 處理排序更新
        $('.sort-order').change(function() {
            const id = $(this).data('id');
            const sortOrder = $(this).val();
            
            $.ajax({
                url: `/admin/activities/${id}/sort`,
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
                url: `/admin/activities/${id}/toggle-active`,
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
    </script>
@endpush
