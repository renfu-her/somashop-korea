@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>免運費設定</h2>
            <a href="{{ route('admin.free-shippings.create') }}" class="btn btn-primary">新增免運設定</a>
        </div>
        <div class="mb-3 alert alert-warning">
            <div class="text-danger">
                開始日期和結束日期可以為空，表示永久有效。<br>
                開始日期和結束日期不得重疊。
            </div>
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
                            <th>開始日期</th>
                            <th>結束日期</th>
                            <th>最低消費金額</th>
                            <th>狀態</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($freeShippings as $freeShipping)
                            <tr>
                                <td>{{ $freeShipping->start_date }}</td>
                                <td>{{ $freeShipping->end_date }}</td>
                                <td>${{ number_format($freeShipping->minimum_amount) }}</td>
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                        <input class="form-check-input toggle-active" type="checkbox"
                                            data-id="{{ $freeShipping->id }}"
                                            {{ $freeShipping->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.free-shippings.edit', $freeShipping) }}"
                                            class="btn btn-sm btn-outline-primary">編輯</a>
                                        <form action="{{ route('admin.free-shippings.destroy', $freeShipping) }}"
                                            method="POST" onsubmit="return confirm('確定要刪除此活動嗎？');">
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
                responsive: true,
                order: [
                    [2, 'asc']
                ],
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });
        });

        $('.toggle-active').change(function() {
            const id = $(this).data('id');
            const isActive = $(this).prop('checked');

            $.ajax({
                url: `/admin/free-shippings/${id}/toggle-active`,
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
