<?php

namespace App\Services;

use App\Mail\GenericMail;
use App\Models\EmailSetting;
use App\Models\Member;
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
            $mailData = array_merge($mailData, $data);

            // 如果沒有指定模板，使用預設模板
            $view = $template ?? 'emails.default';

            // 發送郵件，並加入密件副本
            $mail = Mail::to($recipients)
                ->bcc($bccEmails)
                ->send(new GenericMail(
                    $subject,
                    $view,
                    $mailData
                ));

            // 記錄成功信息
            Log::info('郵件發送成功', [
                'recipients' => $recipients,
                'subject' => $subject,
                'connection_status' => config('mail.default'),
                'mailer_settings' => [
                    'host' => config('mail.mailers.' . config('mail.default') . '.host'),
                    'port' => config('mail.mailers.' . config('mail.default') . '.port'),
                ],
                'message_id' => $mail->getMessage()->getId(),
                'time' => now(),
            ]);

            return true;
        } catch (TransportException $e) {
            // SMTP 連接問題
            Log::error('郵件伺服器連接失敗', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'connection' => config('mail.default'),
            ]);
            return false;
        } catch (\Exception $e) {
            // 其他錯誤
            Log::error('郵件發送失敗', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
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
}
