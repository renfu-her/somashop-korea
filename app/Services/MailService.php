<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\GenericMail;
use App\Models\Member;

class MailService
{
    /**
     * 發送郵件
     *
     * @param string|array $to 收件者
     * @param string $subject 郵件主旨
     * @param string|array $content 郵件內容
     * @param string|null $template 郵件模板
     * @param array $data 額外資料
     * @return bool
     */
    public function send($to, string $subject, $content, ?string $template = null, array $data = []): bool
    {
        try {
            // 處理收件者格式
            $recipients = is_array($to) ? $to : ['email' => $to];

            // 處理內容格式
            $mailData = is_array($content) ? $content : ['content' => $content];
            $mailData = array_merge($mailData, $data);

            // 如果沒有指定模板，使用預設模板
            $view = $template ?? 'emails.default';

            // 發送郵件
            Mail::to($recipients)->send(new GenericMail(
                $subject,
                $view,
                $mailData
            ));

            return true;
        } catch (\Exception $e) {
            Log::error('Mail sending failed', [
                'to' => $to,
                'subject' => $subject,
                'content' => $content,
                'template' => $template,
                'data' => $data,
                'error' => $e->getMessage()
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