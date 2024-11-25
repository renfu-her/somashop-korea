@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>首頁主廣告管理</h2>
            <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">新增廣告</a>
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

                            <th>圖片</th>
                            <th>標題</th>
                            <th style="width: 8%">排序</th>
                            <th>狀態</th>
                            <th>開始日期</th>
                            <th>結束日期</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ads as $ad)
                            <tr>
                                <td>{{ $ad->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/ads/' . $ad->image) }}" alt="{{ $ad->title }}"
                                        width="200" />
                                </td>
                                <td>{{ $ad->title }}</td>
                                <td>{{ $ad->sort_order }}</td>
                                <td>
                                    <span class="badge {{ $ad->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $ad->is_active ? '啟用' : '停用' }}
                                    </span>
                                </td>
                                <td>{{ $ad->start_date->format('Y-m-d') }}</td>
                                <td>{{ $ad->end_date ? $ad->end_date->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.ads.edit', $ad) }}"
                                            class="btn btn-sm btn-outline-primary">編輯</a>
                                        <form action="{{ route('admin.ads.destroy', $ad) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('確定要刪除此廣告嗎？');">
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

@push('styles')
    <style>
        .table td img,
        .jsgrid .jsgrid-table td img {
            width: auto;
            border-radius: 0 !important;
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
                    [3, 'asc']
                ],
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
