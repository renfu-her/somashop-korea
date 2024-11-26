@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>系統設定管理</h2>
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.settings.create') }}" class="btn btn-primary">新增設定</a>
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
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th>設定名稱</th>
                            <th>設定值</th>
                            <th>說明</th>
                            <th>最後更新時間</th>
                            <th style="width: 15%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $setting)
                            <tr>
                                <td>{{ $setting->id }}</td>
                                <td>{{ $setting->key }}</td>
                                <td>{{ $setting->value }}</td>
                                <td>{{ $setting->description }}</td>
                                <td>{{ $setting->updated_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.settings.edit', $setting->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            編輯
                                        </a>
                                        @if(!in_array($setting->key, ['shipping_fee', '711_shipping_fee', 'family_shipping_fee'])) {{-- 防止刪除基本設定 --}}
                                        <form action="{{ route('admin.settings.destroy', $setting->id) }}" 
                                            method="POST" onsubmit="return confirm('確定要刪除此設定嗎？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                刪除
                                            </button>
                                        </form>
                                        @endif
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
                ordering: false,
            });
        });
    </script>
@endpush 