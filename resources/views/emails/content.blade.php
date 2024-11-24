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
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
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
    <div class="header">
        <img src="{{ asset('frontend/img/logo_1.png') }}" alt="Logo" class="logo">
        <h2>{{ $title }}</h2>
    </div>

    <div class="content">
        {!! nl2br(e($content)) !!}

        @if(isset($button))
            <div style="text-align: center;">
                <a href="{{ $button['url'] }}" class="button">
                    {{ $button['text'] }}
                </a>
            </div>
        @endif
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} 德善堂. All rights reserved.</p>
        <p>桃園市桃園區中正路 1247 號 15 樓之 4</p>
    </div>
</body>
</html> 