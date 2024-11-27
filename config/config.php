<?php

return [
    'ecpay_merchant_id' => env('ECPAY_MERCHANT_ID', '3002607'),
    'ecpay_hash_key' => env('ECPAY_HASH_KEY', 'pwFHCqoQZGmho4w6'),
    'ecpay_hash_iv' => env('ECPAY_HASH_IV', 'EkRm7iFT261dpevs'),
    'ecpay_map_api' => env('ECPAY_MAP_API', 'https://logistics.ecpay.com.tw/Express/map'),

    'ecpay_stage_merchant_id' => env('ECPAY_STAGE_MERCHANT_ID', '3002607'),
    'ecpay_stage_hash_key' => env('ECPAY_STAGE_HASH_KEY', 'pwFHCqoQZGmho4w6'),
    'ecpay_stage_hash_iv' => env('ECPAY_STAGE_HASH_IV', 'EkRm7iFT261dpevs'),
    'ecpay_stage_map_api' => env('ECPAY_STAGE_MAP_API', 'https://logistics-stage.ecpay.com.tw/Express/map'),

    'ecpay_shipment_merchant_id' => env('ECPAY_SHIPMENT_MERCHANT_ID', '2000132'),
    'ecpay_shipment_hash_key' => env('ECPAY_SHIPMENT_HASH_KEY', '5294y06JbISpM5x9'),
    'ecpay_shipment_hash_iv' => env('ECPAY_SHIPMENT_HASH_IV', 'v77hoKGq4kWxNNIS'),
    'ecpay_shipment_api' => env('ECPAY_SHIPMENT_API', 'https://logistics.ecpay.com.tw/Express/Create'),

    'ecpay_stage_shipment_api' => env('ECPAY_STAGE_SHIPMENT_API', 'https://logistics-stage.ecpay.com.tw/Express/Create'),
    'ecpay_stage_shipment_merchant_id' => env('ECPAY_STAGE_SHIPMENT_MERCHANT_ID', '2000132'),
    'ecpay_stage_shipment_hash_key' => env('ECPAY_STAGE_SHIPMENT_HASH_KEY', '5294y06JbISpM5x9'),
    'ecpay_stage_shipment_hash_iv' => env('ECPAY_STAGE_SHIPMENT_HASH_IV', 'v77hoKGq4kWxNNIS'),

    'app_run' => env('APP_RUN', 'local'),
];
