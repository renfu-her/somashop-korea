<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: "Microsoft JhengHei", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .warning {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="EzHive Logo" style="max-width: 200px;">
        </div>
        
        <div class="content">
            @yield('content')
        </div>
        
        <div class="footer">
            <p>======本信件由系統自動發送，請勿直接回覆本信件，謝謝!======</p>
            <p>© {{ date('Y') }} 편안잠購物車. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 