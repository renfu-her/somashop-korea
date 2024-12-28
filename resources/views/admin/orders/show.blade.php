@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>訂單詳情 #{{ $order->order_number }}</h2>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">返回列表</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- 訂單商品 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">商品資訊</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($order->items as $item)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $item->product_image_url }}" class="product-thumbnail me-3"
                                    alt="{{ $item->product_name }}" style="width: 100px; height: 100px;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                    @if ($item->spec)
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
                            <div class="col-md-12">
                                <table class="table table-borderless mb-0">
                                    @php
                                        $subtotal = $order->items->sum('total');
                                        $total = $subtotal + $order->shipping_fee;
                                    @endphp
                                    <tr>
                                        <td>商品小計：</td>
                                        <td class="text-end">NT$ {{ number_format($subtotal) }}</td>
                                    </tr>
                                    <tr>
                                        <td>運費：</td>
                                        <td class="text-end">NT$ {{ number_format($order->shipping_fee) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>總計：</strong></td>
                                        <td class="text-end">
                                            <strong>NT$ {{ number_format($total) }}</strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST"
                            class="d-flex justify-content-end">
                            @method('PUT')
                            <div class="me-2">
                                <select name="status" class="form-select" style="width: 100px;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>待處理
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>處理中
                                    </option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>已結案
                                    </option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>已作廢
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">修改訂單狀態</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- 訂單狀態 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">訂單狀態</h5>
                    </div>
                    <div class="card-body" style="height: 180px;">
                        <p class="mb-2">
                            訂單狀態：
                            <span class="badge bg-primary">{{ $order->status_text }}</span>
                        </p>
                        <p class="mb-2">
                            付款方式：{{ $order->payment_method == 'credit' ? '信用卡' : 'ATM' }}
                        </p>
                        <p class="mb-2">
                            付款狀態：
                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                {{ $order->payment_status_text }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">運送資訊</h5>
                    </div>
                    @if (empty($order->logistics_id))
                        <div class="card-body">
                            <p class="mb-2">
                                寄送方式：{{ $shipmentMethodName }}
                            </p>

                            @if ($shipmentMethodName != '郵寄')
                                <p class="mb-2">
                                    店家名稱：{{ $order->store_name }}
                                </p>
                                <p class="mb-2">
                                    店家電話：{{ $order->store_telephone }}
                                </p>
                                <p class="mb-2">
                                    店家地址：{{ $order->store_address }}
                                </p>
                            @endif

                            <p class="mb-2">
                                收件者：{{ $order->recipient_name }}
                            </p>
                            <p class="mb-2">
                                手機：{{ $order->recipient_phone }}
                            </p>
                            <p class="mb-2">
                                性別：{{ $order->member->gender == 1 ? '男' : '女' }}
                            </p>

                            <p class="mb-2">
                                寄貨地址：{{ $order->shipping_county }}{{ $order->shipping_district }}
                                {{ $order->shipping_address }}
                            </p>
                            <p class="mb-2">
                                運送狀態：
                                <select class="form-select" id="shipping-status"
                                    onchange="updateShippingStatus(this, {{ $order->id }})">
                                    <option value="processing" @if ($order->shipping_status === 'processing') selected @endif>處理中
                                    </option>
                                    <option value="pending" @if ($order->shipping_status === 'pending') selected @endif>待出貨
                                    </option>
                                    <option value="shipped" @if ($order->shipping_status === 'shipped') selected @endif>已出貨
                                    </option>
                                </select>
                            </p>
                        </div>
                    @else
                        <div class="card-body">
                            <p class="mb-2">
                                寄送方式：{{ $shipmentMethodName }}
                            </p>
                            <p class="mb-2">
                                緑界物流單號：{{ $order->logistics_id }}
                            </p>
                            <p class="mb-2">
                                物流單號：{{ $order->shipment_no }}
                            </p>
                            <p class="mb-2">
                                運送狀態：
                                <span class="badge bg-info">{{ $order->shipping_status_text }}</span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <!-- 訂單備註 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">備註</h5>
                    </div>
                    <div class="card-body" style="height: 180px;">
                        <p class="mb-2">
                            {{ $order->note }}
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">發票資訊</h5>
                    </div>
                    <div class="card-body" style="height: 157px;">
                        <p class="mb-2">
                            發票號碼
                            <input type="text" class="form-control text-uppercase" value="{{ $order->issued_invoice_number ?? '' }}"
                                id="issued-invoice-number" maxlength="8">
                        </p>
                    </div>
                </div>

                @if ($order->invoice_title != '')
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">發票三聯單資訊</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                發票抬頭：{{ $order->invoice_title }}
                            </p>
                            <p class="mb-2">
                                統一編號：{{ $order->invoice_number }}
                            </p>
                            <p class="mb-2">
                                發票地址：{{ $order->invoice_county }}{{ $order->invoice_district }}
                                {{ $order->invoice_address }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#issued-invoice-number').on('keyup', function() {
                // console.log($(this).val());
                $.ajax({
                    url: '{{ route('admin.orders.update-invoice-number') }}',
                    method: 'POST',
                    data: {
                        invoice_number: $(this).val(),
                        order_number: '{{ $order->order_number }}'
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        });

        // 更新運送狀態
        function updateShippingStatus(select, orderId) {
            // console.log(select.value);
            // console.log(orderId);
            $.ajax({
                url: '{{ route('admin.orders.update-shipping-status') }}',
                method: 'POST',
                data: {
                    status: select.value,
                    order_id: orderId
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }
    </script>
@endpush
