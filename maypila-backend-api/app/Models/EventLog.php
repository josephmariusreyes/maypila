<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $company_id
 * @property string $event_type
 * @property string $event_description
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class EventLog extends Model
{
    protected $table = 'event_logs';

    protected $fillable = [
        'user_id',
        'company_id',
        'event_type',
        'event_description',
        'metadata',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
