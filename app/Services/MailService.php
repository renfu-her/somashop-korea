<?php

namespace App\Services;

use App\Mail\GenericMail;
use App\Models\EmailSetting;
use App\Models\EmailQueue;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class MailService
{
    /**
     * 發送郵件
     */
    public function send($to, string $subject, $content, ?string $template = null, array $data = []): bool
    {
        try {
            // 獲取所有啟用的郵件設定
            $bccEmails = EmailSetting::where('is_active', true)
                ->pluck('email')
                ->toArray();

            // 處理收件者格式
            $recipients = is_array($to) ? $to : ['email' => $to];

            // 處理內容格式
            $mailData = is_array($content) ? $content : ['content' => $content];
            
            // 確保 data 中的 order 是陣列格式
            if (isset($data['order']) && is_object($data['order'])) {
                $data['order'] = $data['order']->toArray();
            }
            
            $mailData = array_merge($mailData, $data);

            // 如果沒有指定模板，使用預設模板
            $view = $template ?? 'emails.default';

            // 將郵件加入佇列
            EmailQueue::create([
                'to' => is_array($to) ? json_encode($to) : $to,
                'subject' => $subject,
                'content' => is_array($content) ? json_encode($content) : $content,
                'template' => $view,
                'data' => $mailData,
                'bcc' => $bccEmails,
                'status' => 'pending'
            ]);

            Log::info('郵件已加入佇列', [
                'to' => $to,
                'subject' => $subject,
                'template' => $view
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('郵件加入佇列失敗', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * 處理佇列中的郵件
     */
    public function processQueue(int $limit = 10): void
    {
        $emails = EmailQueue::where('status', 'pending')
            ->where('attempts', '<', 3)
            ->orderBy('created_at', 'asc')
            ->limit($limit)
            ->get();

        foreach ($emails as $email) {
            try {
                $email->update([
                    'status' => 'processing',
                    'attempts' => $email->attempts + 1
                ]);

                // 發送郵件
                $mail = Mail::to($email->to)
                    ->bcc($email->bcc ?? [])
                    ->send(new GenericMail(
                        $email->subject,
                        $email->template,
                        $email->data
                    ));

                $email->update([
                    'status' => 'completed',
                    'processed_at' => now()
                ]);

                Log::info('郵件發送成功', [
                    'email_id' => $email->id,
                    'to' => $email->to,
                    'subject' => $email->subject
                ]);
            } catch (\Exception $e) {
                $email->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage()
                ]);

                Log::error('郵件發送失敗', [
                    'email_id' => $email->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * 發送歡迎郵件
     */
    public function sendWelcomeMail(Member $member): bool
    {
        $subject = '歡迎加入會員';
        $content = [
            'title' => '歡迎加入',
            'content' => "親愛的 {$member->name} 您好，\n\n感謝您加入我們的會員...",
            'button' => [
                'text' => '開始購物',
                'url' => route('home')
            ]
        ];

        return $this->send(
            $member->email,
            $subject,
            $content,
            'emails.welcome',
            ['member' => $member]
        );
    }

    /**
     * 發送問題回饋郵件
     */
    public function sendFeedbackMail(string $email, string $message): bool
    {
        $subject = '問題回饋';
        $content = ['content' => $message];

        return $this->send(
            $email,
            $subject,
            $content,
            'emails.feedback',
            ['content' => $message]
        );
    }

    /**
     * 發送密碼重置郵件
     */
    public function sendResetPasswordMail(Member $member, string $token): bool
    {
        $subject = '重設密碼通知';
        $content = [
            'title' => '重設密碼',
            'content' => "您已申請重設密碼，請點擊下方按鈕進行重設。",
            'button' => [
                'text' => '重設密碼',
                'url' => route('password.reset', $token)
            ]
        ];

        return $this->send(
            $member->email,
            $subject,
            $content,
            'emails.reset-password',
            [
                'member' => $member,
                'token' => $token
            ]
        );
    }

    /**
     * 檢查郵件伺服器連線狀態
     */
    public function checkMailConnection(): array
    {
        try {
            // 獲取當前郵件配置
            $driver = config('mail.default');
            $config = config('mail.mailers.' . $driver);

            // 建立 SMTP 連線
            $transport = new EsmtpTransport(
                $config['host'],
                $config['port'],
                $config['encryption'] ?? null,
                $config['username'] ?? null,
                $config['password'] ?? null
            );

            // 測試連線
            $transport->start();

            $status = [
                'success' => true,
                'message' => '郵件伺服器連線成功',
                'details' => [
                    'driver' => $driver,
                    'host' => $config['host'],
                    'port' => $config['port'],
                    'encryption' => $config['encryption'] ?? 'none',
                    'from_address' => config('mail.from.address'),
                    'from_name' => config('mail.from.name'),
                    'timestamp' => now()->toDateTimeString()
                ]
            ];

            // 關閉連線
            $transport->stop();
        } catch (TransportException $e) {
            $status = [
                'success' => false,
                'message' => '郵件伺服器連線失敗：' . $e->getMessage(),
                'details' => [
                    'driver' => $driver,
                    'host' => $config['host'] ?? null,
                    'port' => $config['port'] ?? null,
                    'error_code' => $e->getCode(),
                    'error_message' => $e->getMessage(),
                    'timestamp' => now()->toDateTimeString()
                ]
            ];

            Log::error('郵件伺服器連線失敗', $status);
        }

        return $status;
    }

    public function sendOrderCompleteEmail(Order $order, $shipmentMethod = 'Credit')
    {
        $member = Member::find($order->member_id);

        // 獲取訂單項目並加載關聯數據
        $orderItems = OrderItem::with([
            'product',
            'spec',
            'product.images' => function ($query) {
                $query->where('is_primary', 1);
            }
        ])->where('order_id', $order->id)->get();

        // 將 orderItems 轉換為陣列格式
        $orderItemsArray = $orderItems->map(function ($item) {
            $itemArray = $item->toArray();
            // 確保 product 和 images 存在
            if (isset($itemArray['product'])) {
                $itemArray['product']['images'] = $item->product->images->toArray();
            }
            return $itemArray;
        })->toArray();

        $this->send(
            $member->email,
            '訂單完成通知',
            [
                'title' => '訂單完成通知',
                'content' => "親愛的 {$order->recipient_name} 您好，\n\n您的訂單已完成...",
                'button' => [
                    'text' => '查看訂單詳情',
                    'url' => route('orders.list')
                ]
            ],
            'emails.order-complete',
            [
                'order' => $order->toArray(),
                'shipmentMethod' => $shipmentMethod,
                'orderItems' => $orderItemsArray
            ]
        );
    }
}
