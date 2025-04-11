<?php

namespace App\Console\Commands;

use App\Services\MailService;
use Illuminate\Console\Command;

class ProcessEmailQueue extends Command
{
    protected $signature = 'email:process {--limit=10 : 每次處理的郵件數量}';
    protected $description = '處理郵件佇列中的郵件';

    private $mailService;

    public function __construct(MailService $mailService)
    {
        parent::__construct();
        $this->mailService = $mailService;
    }

    public function handle()
    {
        $limit = $this->option('limit');
        
        $this->info('開始處理郵件佇列...');
        
        $this->mailService->processQueue($limit);
        
        $this->info('郵件佇列處理完成');
    }
} 