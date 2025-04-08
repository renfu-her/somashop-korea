<!DOCTYPE html>
<html>
<head>
    <title>轉向到綠界支付...</title>
</head>
<body>
    <form id="ecpay-form" method="post" action="{{ $apiUrl }}" style="display: none;">
        @foreach($ecpayData as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
    <script>
        document.getElementById('ecpay-form').submit();
    </script>
</body>
</html> 