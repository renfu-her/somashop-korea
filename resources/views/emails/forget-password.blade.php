<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: "Microsoft JhengHei", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
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
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .password {
            background-color: #f5f5f5;
            padding: 10px;
            margin: 10px 0;
            border-radius: 3px;
            font-family: monospace;
            font-size: 16px;
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
            background-color: #007bff;
            color: #fff;
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
            <h2>密碼重置通知</h2>
        </div>
        
        <div class="content">
            <p>{{ $name }}，您好：</p>
            
            <p>您剛在德善堂購物車申請了一組新的密碼。</p>
            
            <p>您的新密碼為：</p>
            <div class="password">
                {{ $password }}
            </div>
            
            <p class="warning">登入後請務必至會員中心修改密碼！</p>
            
            <p>歡迎直接進入德善堂線上購物：</p>
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}" class="button">前往購物網站</a>
            </div>
        </div>
        
        <div class="footer">
            <p>======本信件由系統自動發送，請勿直接回覆本信件，謝謝!======</p>
            <p>© 2024 德善堂購物車. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 