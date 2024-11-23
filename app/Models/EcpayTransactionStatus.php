<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcpayTransactionStatus extends Model
{
    protected $table = 'ecpay_transaction_statuses';
    protected $fillable = [
        'code',
        'message'
    ];
}
