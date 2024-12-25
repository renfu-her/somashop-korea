<?php

namespace App\Services;

use App\Mail\GenericMail;
use App\Models\EmailSetting;
use App\Models\Member;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailService
{
    /**
     * 發送郵件
     */
    public function send($to, string $subject, $content, ?string $template = null, array $data = []): bool
    {
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

        // try {
        // 發送郵件，並加入密件副本
        $mail = Mail::to($recipients)
            ->bcc($bccEmails)
            ->send(new GenericMail(
                $subject,
                $view,
                $mailData
            ))->getDebug();

        Log::info('郵件發送詳細資訊', [
            'recipients' => $recipients,
            'bcc' => $bccEmails, 
            'subject' => $subject,
            'view' => $view,
            'data' => $mailData,
            'result' => $mail,
            'mail' => $mail->getMessage(),
        ]);

        return true;
        // } catch (\Exception $e) {
        //     Log::error('郵件發送失敗：' . $e->getMessage());
        //     return false;
        // }
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
}
