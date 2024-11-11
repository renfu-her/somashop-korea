@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>廣告管理</h2>
            <a href="{{ route('admin.adverts.create') }}" class="btn btn-primary">新增廣告</a>
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
                            <th>標題</th>
                            <th>圖片</th>
                            <th>狀態</th>
                            <th>開始日期</th>
                            <th>結束日期</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adverts as $advert)
                            <tr>
                                <td>{{ $advert->id }}</td>
                                <td>{{ $advert->title }}</td>
                                <td>
                                    <img src="{{ asset('storage/adverts/' . $advert->image) }}" alt="{{ $advert->title }}"
                                        style="max-width: 100px">
                                </td>
                                <td>
                                    <span class="badge {{ $advert->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $advert->is_active ? '啟用' : '停用' }}
                                    </span>
                                </td>
                                <td>{{ $advert->start_date->format('Y-m-d') }}</td>
                                <td>{{ $advert->end_date ? $advert->end_date->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.adverts.edit', $advert) }}"
                                            class="btn btn-sm btn-outline-primary">編輯</a>
                                        <form action="{{ route('admin.adverts.destroy', $advert) }}" method="POST"
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

                <div class="mt-4">
                    {{ $adverts->links() }}
                </div>
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
                    [0, 'desc']
                ],
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
