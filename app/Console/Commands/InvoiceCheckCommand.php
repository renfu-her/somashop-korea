<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use TsaiYiHua\ECPay\Checkout;
use TsaiYiHua\ECPay\Invoice;
use TsaiYiHua\ECPay\Constants\ECPayDonation;
use TsaiYiHua\ECPay\Services\StringService;

class InvoiceCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:invoice-check-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '檢查已付款但未開立發票的訂單';

    private $hashKey;
    private $hashIV;
    private $merchantId;
    private $apiUrl;

    private $checkout;
    private $invoice;

    public function __construct(Checkout $checkout, Invoice $invoice)
    {
        parent::__construct();

        $this->checkout = $checkout;
        $this->invoice = $invoice;

        $this->merchantId = config('app.env') === 'production' ? config('config.ecpay_invoice_merchant_id') : config('config.ecpay_invoice_stage_merchant_id');
        $this->hashKey = config('app.env') === 'production' ? config('config.ecpay_invoice_hash_key') : config('config.ecpay_invoice_stage_hash_key');
        $this->hashIV = config('app.env') === 'production' ? config('config.ecpay_invoice_hash_iv') : config('config.ecpay_invoice_stage_hash_iv');

        $this->apiUrl = config('app.env') === 'production'
            ? 'https://einvoice.ecpay.com.tw/B2CInvoice/Issue'
            : 'https://einvoice-stage.ecpay.com.tw/B2CInvoice/Issue';
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        set_time_limit(0);

        $yesterday = Carbon::yesterday();

        // 獲取昨天已付款但未開立發票的訂單
        $orders = Order::where('payment_status', 'paid')
            ->where('invoice_checked', false)
            ->get();

        foreach ($orders as $order) {
            sleep(1);
            $invoice = $this->prepareInvoiceData($order);

            if ($invoice['RtnCode'] === '1') {
                $order->invoice_checked = true;
                $order->issued_invoice_number = $invoice['InvoiceNumber'];
                $order->issued_invoice_date = $invoice['InvoiceDate'];
                $order->save();

                Log::info('開立發票成功', [
                    'order_id' => $order->id,
                    'invoice_number' => $invoice['InvoiceNumber'],
                    'invoice_date' => $invoice['InvoiceDate'],
                ]);
            }
        }
    }

    private function prepareInvoiceData($order)
    {

        $member = Member::find($order->member_id);

        $items = [];
        $itemSeq = 1;
        foreach ($order->items as $item) {
            $items[] = [
                'name' => $item->product->name,
                'qty' => $item->quantity,
                'unit' => '個',
                'price' => $item->price,
            ];
        }

        // 加入運費項目
        if ($order->shipping_fee > 0) {
            $items[] = [
                'name' => '運費',
                'qty' => 1,
                'unit' => '個',
                'price' => $order->shipping_fee,
            ];
        }

        $invoiceData = [
            'UserId' => $member->id,
            'Items' => $items,
            'CustomerName' => $order->invoice_title ?? $member->name,
            'CustomerPhone' => $member->phone,
            'CustomerEmail' => $member->email,
            'OrderId' => $order->order_number,
            'Donation' => 0,
            'CarrierType' => 1,
        ];
        if ($order->invoice_number) {
            $invoiceData['CustomerIdentifier'] = $order->invoice_number;
            $invoiceData['Print'] = 1;
            $invoiceData['CustomerAddr'] = $order->invoice_county . $order->invoice_district . $order->invoice_address;
        } else {
            $invoiceData['Print'] = 0;
        }

        return $this->invoice->setPostData($invoiceData)->send();
    }
}
