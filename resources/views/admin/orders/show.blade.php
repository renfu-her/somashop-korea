@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>訂單詳情 #{{ $order->order_number }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">返回列表</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- 訂單商品 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">商品資訊</h5>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $item->product_image_url }}" 
                             class="product-thumbnail me-3" 
                             alt="{{ $item->product_name }}" style="width: 100px; height: 100px;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $item->product_name }}</h6>
                            @if($item->spec)
                                <p class="text-muted mb-1">規格：{{ $item->spec->name }}</p>
                            @endif
                            <p class="mb-0">
                                數量：{{ $item->quantity }} × NT$ {{ number_format($item->price) }}
                                <span class="float-end">NT$ {{ number_format($item->total) }}</span>
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer text-end">
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>商品小計：</td>
                                    <td class="text-end">NT$ {{ number_format($order->total_amount - $order->shipping_fee) }}</td>
                                </tr>
                                <tr>
                                    <td>運費：</td>
                                    <td class="text-end">NT$ {{ number_format($order->shipping_fee) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>總計：</strong></td>
                                    <td class="text-end"><strong>NT$ {{ number_format($order->total_amount) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- 訂單狀態 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">訂單狀態</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        訂單狀態：
                        <span class="badge bg-primary">{{ $order->status_text }}</span>
                    </p>
                    <p class="mb-2">
                        付款狀態：
                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ $order->payment_status_text }}
                        </span>
                    </p>
                    <p class="mb-2">
                        運送狀態：
                        <span class="badge bg-info">{{ $order->shipping_status_text }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 