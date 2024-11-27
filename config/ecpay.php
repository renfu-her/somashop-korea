<?php
return [
    'MerchantId' => env('ECPAY_INVOICE_MERCHANT_ID', '2000132'),
    'HashKey' => env('ECPAY_INVOICE_HASH_KEY', 'ejCk326UnaZWKisg'),
    'HashIV' => env('ECPAY_INVOICE_HASH_IV', 'ZX8Ib9LM8wYk'),
    'InvoiceHashKey' => env('ECPAY_INVOICE_STAGE_HASH_KEY', 'ejCk326UnaZWKisg'),
    'InvoiceHashIV' => env('ECPAY_INVOICE_STAGE_HASH_IV', 'q9jcZX8Ib9LM8wYk'),
    'SendForm' => env('ECPAY_SEND_FORM', null)
];