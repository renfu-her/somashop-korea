@extends('emails.layout')

@section('content')
<div class="content">
    <h2>訂單完成通知</h2>
    
    <p>親愛的 {{ $order->recipient_name }} 您好,</p>
    <p>感謝您的訂購,以下是您的訂單明細：</p>
    
    <div class="order-details">
        <h3>訂單編號: {{ $order->order_number }}</h3>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 8px; border: 1px solid #dee2e6;">商品</th>
                    <th style="padding: 8px; border: 1px solid #dee2e6;">規格</th>
                    <th style="padding: 8px; border: 1px solid #dee2e6;">數量</th>
                    <th style="padding: 8px; border: 1px solid #dee2e6;">單價</th>
                    <th style="padding: 8px; border: 1px solid #dee2e6;">小計</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{{ $item->product->name }}</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{{ $item->spec ? $item->spec->value : '-' }}</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">{{ $item->quantity }}</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">NT${{ number_format($item->price) }}</td>
                    <td style="padding: 8px; border: 1px solid #dee2e6;">NT${{ number_format($item->price * $item->quantity) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; text-align: right;">
            <p>運費: NT${{ number_format($order->shipping_fee) }}</p>
            <p>總計: NT${{ number_format($order->total_amount) }}</p>
        </div>
    </div>

    <div class="shipping-info" style="margin-top: 30px;">
        <h3>配送資訊</h3>
        <p>收件人: {{ $order->recipient_name }}</p>
        <p>聯絡電話: {{ $order->recipient_phone }}</p>
        @if($order->shipment_method == 'mail_send')
            <p>配送地址: {{ $order->recipient_county }}{{ $order->recipient_district }}{{ $order->recipient_address }}</p>
        @elseif($order->shipment_method == '711_b2c')
            <p>取貨門市: 7-11門市取貨</p>
        @elseif($order->shipment_method == 'family_b2c')
            <p>取貨門市: 全家便利商店取貨</p>
        @endif
    </div>

    <div style="margin-top: 30px;">
        <p>如有任何問題,請隨時與我們聯繫。</p>
        <p>祝您購物愉快！</p>
    </div>
</div>
@endsection 