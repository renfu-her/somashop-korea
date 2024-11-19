<!DOCTYPE html>
<html>
<head>
    <script>
        window.onload = function() {
            // 將資料傳送給父視窗
            window.opener.postMessage({
                type: 'STORE_SELECTED',
                data: {
                    store_id: '{{ $store_data["CVSStoreID"] }}',
                    store_name: '{{ $store_data["CVSStoreName"] }}',
                    store_address: '{{ $store_data["CVSAddress"] }}',
                    store_telephone: '{{ $store_data["CVSTelephone"] }}'
                }
            }, '*');
            
            // 關閉當前視窗
            window.close();
        };
    </script>
</head>
<body>
    處理中...
</body>
</html> 