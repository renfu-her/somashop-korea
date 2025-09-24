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
            <h2>비밀번호 재설정 안내</h2>
        </div>
        
        <div class="content">
            <p>{{ $member['name'] }}님, 안녕하세요：</p>
            
            <p>SOMA SHOP에서 새로운 비밀번호를 요청하셨습니다.</p>
            
            <p>새로운 비밀번호는 다음과 같습니다：</p>
            <div class="password">
                {{ $password }}
            </div>
            
            <p class="warning">로그인 후 반드시 회원센터에서 비밀번호를 변경해주세요！</p>
            
            <p>EzHive 온라인 쇼핑몰에 직접 접속하세요：</p>
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}" class="button" style="color: #fff !important; background-color: #007bff !important;">쇼핑몰 바로가기</a>
            </div>
        </div>
        
        <div class="footer">
            <p>======이 메일은 시스템에서 자동으로 발송된 것으로, 직접 회신하지 마시기 바랍니다. 감사합니다!======</p>
            <p>© 2024 SOMA SHOP. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 