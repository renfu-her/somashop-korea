<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    protected $table = 'email_queue';

    protected $fillable = [
        'to',
        'subject',
        'content',
        'template',
        'data',
        'bcc',
        'status',
        'error_message',
        'attempts',
        'processed_at',
        'scheduled_at',
        'priority',
        'type',
        'mailable_type',
        'mailable_id'
    ];

    protected $casts = [
        'data' => 'array',
        'bcc' => 'array',
        'processed_at' => 'datetime',
        'scheduled_at' => 'datetime'
    ];

    /**
     * 取得關聯的模型
     */
    public function mailable()
    {
        return $this->morphTo();
    }

    /**
     * 取得待處理的郵件
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending')
            ->where(function ($q) {
                $q->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->where('attempts', '<', 3)
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc');
    }

    /**
     * 取得高優先級的郵件
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    /**
     * 取得特定類型的郵件
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
} 