<?php

namespace App\Constants\ApiDocs;

class QueueSessionDocs
{
    public const QUEUE_SESSION_COLLECTION = [
        self::QUEUE_SESSION
    ];

    public const QUEUE_SESSION = [
        'id' => 1,
        'created_by' => 'Mark',
        'company_id' => 1,
        'queue_status' => '1',
        'name' => 'Test queue',
        'description' => 'Test description',
        'created_at' => '2026-01-15T10:30:00.000000Z',
        'updated_at' => '2026-01-15T10:30:00.000000Z'
    ];
}
