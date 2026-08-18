<?php

namespace App\Constants\ApiDocs;

class UserResourceDocs
{
    public const USER_COLLECTION = [
        self::USER
    ];

    //User
    public const USER = [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'mobile_number' => '+1234567890',
        'queue_session_id' => 1,
        'email_verified_at' => '2026-01-15T10:30:00.000000Z',
        'created_at' => '2026-01-15T10:30:00.000000Z',
        'updated_at' => '2026-01-15T10:30:00.000000Z',
        'roles' => self::USER_ROLES,
        'companies' => self::USER_COMPANIES,
        'queue_session' => self::USER_QUEUE_SESSION,
    ];

    public const USER_ROLES = [
        [
            'id' => 1,
            'name' => 'admin',
            'created_at' => '2026-01-15T10:30:00.000000Z',
            'updated_at' => '2026-01-15T10:30:00.000000Z',
        ],
        [
            'id' => 2,
            'name' => 'user',
            'created_at' => '2026-01-15T10:30:00.000000Z',
            'updated_at' => '2026-01-15T10:30:00.000000Z',
        ],
    ];

    public const USER_COMPANIES = [
        [
            'id' => 1,
            'name' => 'Acme Corp',
            'description' => 'Leading technology solutions provider',
            'created_at' => '2026-01-15T10:30:00.000000Z',
            'updated_at' => '2026-01-15T10:30:00.000000Z',
        ],
        [
            'id' => 2,
            'name' => 'Tech Innovators',
            'description' => 'Innovative software development',
            'created_at' => '2026-01-15T10:30:00.000000Z',
            'updated_at' => '2026-01-15T10:30:00.000000Z',
        ],
    ];

    public const USER_QUEUE_SESSION = [
        'id' => 1,
        'created_by' => 1,
        'company_id' => 1,
        'name' => 'Morning Queue',
        'description' => 'Queue for morning shift',
        'queue_status' => 'active',
        'created_at' => '2026-01-15T10:30:00.000000Z',
        'updated_at' => '2026-01-15T10:30:00.000000Z',
    ];
}
