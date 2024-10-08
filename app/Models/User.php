<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;
    use HasRoles,HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected static $logAttributes = ['name', 'email'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} batch";
    }
    /**
     * Get the options for logging activity.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                // Define the log name here
                $logName = 'User';
    
                switch ($eventName) {
                    case 'created':
                        return "{$logName} has been created with the following details: Name - {$this->name}, Email - {$this->email}, Status - {$this->status}";
                    case 'updated':
                        return "{$logName} has been updated. New details: Name - {$this->name}, Email - {$this->email}, Status - {$this->status}";
                    case 'deleted':
                        return "{$logName} with Email - {$this->email} has been deleted.";
                    default:
                        return "{$logName} has been {$eventName}.";
                }
            })
            ->useLogName('User Management');
    }
    
}