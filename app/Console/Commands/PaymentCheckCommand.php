<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class PaymentCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:payment-check-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '結帳的出貨檢查';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('payment_status', 'paid')->get();
        foreach ($orders as $order) {
            if($order->payment_date == null){
                $order->payment_date = now();
                $order->save();
            }
        }
    }
}
