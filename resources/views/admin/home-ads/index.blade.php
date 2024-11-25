@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>小幅廣告管理</h2>
            <a href="{{ route('admin.home-ads.create') }}" class="btn btn-primary">新增廣告</a>
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
                            <th>連結</th>
                            <th>排序</th>
                            <th>狀態</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ads as $ad)
                            <tr>
                                <td>{{ $ad->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/home_ads/' . $ad->image) }}" 
                                         alt="{{ $ad->title }}"
                                         class="img-thumbnail">
                                </td>
                                <td>{{ $ad->title }}</td>
                                <td>{{ $ad->link }}</td>
                                <td>{{ $ad->sort_order }}</td>
                                <td>
                                    <span class="badge bg-{{ $ad->is_active ? 'success' : 'danger' }}">
                                        {{ $ad->is_active ? '啟用' : '停用' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.home-ads.edit', $ad) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        <form action="{{ route('admin.home-ads.destroy', $ad) }}" 
                                              method="POST"
                                              onsubmit="return confirm('確定要刪除此廣告嗎？');">
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
        .table td img {
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
                order: [[4, 'asc']],
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });
        });
    </script>
@endpush 