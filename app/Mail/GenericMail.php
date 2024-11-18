<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class GenericMail extends Mailable
{
    protected $mailSubject;
    protected $mailView;
    protected $mailData;

    public function __construct(string $subject, string $view, array $data)
    {
        $this->mailSubject = $subject;
        $this->mailView = $view;
        $this->mailData = $data;
    }

    public function build()
    {
        return $this->subject($this->mailSubject)
                    ->view($this->mailView)
                    ->with($this->mailData);
    }
} 