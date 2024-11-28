@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>訂單管理</h2>
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
                            <th>訂單編號</th>
                            <th>會員</th>
                            <th>商品資訊</th>
                            <th>付款方式</th>
                            <th>總金額</th>
                            <th>付款狀態</th>
                            <th>訂單狀態</th>
                            <th>運送狀態</th>
                            <th>建立時間</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->member->name ?? '' }}</td>
                                <td>
                                    @foreach ($order->items as $item)
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $item->product_image_url }}" class="product-thumbnail me-2"
                                                alt="{{ $item->product_name }}">
                                            <div>
                                                <div>{{ $item->product_name }}</div>
                                                @if ($item->spec)
                                                    @if (!empty($item->spec->name))
                                                        <small class="text-muted">{{ $item->spec->name ?? '' }}</small>
                                                    @endif
                                                @endif
                                                <div class="text-muted">
                                                    數量: {{ $item->quantity }} × NT$ {{ number_format($item->price) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ $order->shipment_method_text }}</td>
                                <td>NT$ {{ number_format($order->total_amount) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                        {{ $order->payment_status_text }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $order->status_text }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $order->shipping_status_text }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            查看
                                        </a>
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
        .product-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

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
                order: [
                    [7, 'desc']
                ], // 按建立時間降序排序
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });
        });
    </script>
@endpush
