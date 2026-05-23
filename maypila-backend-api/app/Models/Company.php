<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $company_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Company extends Model
{
    protected $fillable = [
        'name',
        'company_email',
        'description',
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function eventLogs()
    {
        return $this->hasMany(EventLog::class);
    }
}
