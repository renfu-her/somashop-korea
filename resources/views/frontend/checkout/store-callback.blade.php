<!DOCTYPE html>
<html>
<head>
    <script>
        window.onload = function() {
            // 부모 창에 데이터 전송
            window.opener.postMessage({
                type: 'STORE_SELECTED',
                data: {
                    store_id: '{{ $store_data["CVSStoreID"] }}',
                    store_name: '{{ $store_data["CVSStoreName"] }}',
                    store_address: '{{ $store_data["CVSAddress"] }}',
                    store_telephone: '{{ $store_data["CVSTelephone"] }}'
                }
            }, '*');
            
            // 현재 창 닫기
            window.close();
        };
    </script>
</head>
<body>
    처리 중...
</body>
</html> 