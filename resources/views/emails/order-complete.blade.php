<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: '微軟正黑體', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-top: 10px;
        }

        .logo {
            height: 100px;
            margin-bottom: 5px;
        }

        .content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>

    <div class="header logo" style="text-align: center;">
        <img src="{{ asset('frontend/img/logo_1.png') }}" alt="Logo" class="logo">
    </div>

    <div class="content">
        <h2>訂單完成通知</h2>

        <p>親愛的 {{ $order->recipient_name }} 您好,</p>
        <p>感謝您的訂購,以下是您的訂單明細：</p>

        <div class="order-details">
            <h3>訂單編號: {{ $order->order_number }}</h3>

            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 8px; border: 1px solid #dee2e6;">圖片</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">商品名稱</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">規格</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">數量</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">單價</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">小計</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderItems as $item)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">
                                @if ($item->product->images->isNotEmpty())
                                    <img src="{{ asset('storage/products/' . $item->product->id . '/' . $item->product->images->first()->image_path) }}"
                                        alt="Product Image" style="width: 100px; height: auto;">
                                @else
                                    <img src="{{ asset('frontend/img/no-image.png') }}" alt="No Image"
                                        style="width: 100px; height: auto;">
                                @endif
                            </td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">{{ $item->product->name }}</td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">
                                {{ $item->spec ? $item->spec->name : '-' }}
                            </td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">{{ $item->quantity }}</td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">NT${{ number_format($item->price) }}
                            </td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">
                                NT${{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 20px; text-align: right;">
                <p>運費: {{ $order->shipping_fee == 0 ? '免運費' : 'NT$' . number_format($order->shipping_fee) }}</p>
                <p>總計: NT${{ number_format($order->total_amount + $order->shipping_fee) }}</p>
            </div>
        </div>

        <div class="shipping-info" style="margin-top: 30px;">
            <h3>配送資訊</h3>
            <p>收件人: {{ $order->recipient_name }}</p>
            <p>聯絡電話: {{ $order->recipient_phone }}</p>
            <p>付費方式: {{ $shipmentMethod == 'ATM' ? 'ATM 虛擬帳號付款' : '信用卡付款' }}</p>
            @if ($order->shipment_method == 'mail_send')
                <p>配送地址:
                    {{ $order->shipping_county }}{{ $order->shipping_district }}{{ $order->shipping_address }}</p>
            @elseif($order->shipment_method == '711_b2c')
                <p>取貨門市: 7-11門市取貨</p>
            @elseif($order->shipment_method == 'family_b2c')
                <p>取貨門市: 全家便利商店取貨</p>
            @endif
            <p>備註: <br>{{ $order->note }}</p>
        </div>

        <div style="margin-top: 30px;">
            <p>如有任何問題,請隨時與我們聯繫。</p>
            <p>祝您購物愉快！</p>
        </div>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} EzHive 易群佶選. All rights reserved.</p>
        <p>桃園市桃園區中正路 1247 號 15 樓之 4</p>
    </div>
</body>

</html>
