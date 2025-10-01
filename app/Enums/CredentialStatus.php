<?php

namespace App\Enums;

enum CredentialStatus: string
{
    //
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case SUSPENDED = 'suspended';
    case REVOKED = 'revoked';
    case PENDING = 'pending';
    case REQUESTED = 'requested';
    case WORKING = 'working';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::EXPIRED => 'Expired',
            self::SUSPENDED => 'Suspended',
            self::REVOKED => 'Revoked',
            self::PENDING=>'Pending',
            self::REQUESTED=>'Requested',
            self::WORKING=>'Working',
            self::COMPLETED=>'Completed',
        };
    }
    public static function options(): array
    {
            return [
                self::ACTIVE->value => "Active",
                self::EXPIRED->value => "Expired",
                self::SUSPENDED->value => "Suspended",
                self::REVOKED->value => "Revoked",
                self::PENDING->value => "Pending",
                self::REQUESTED->value => "Requested",
                self::WORKING->value => "Working",
                self::COMPLETED->value => "Completed",
                
            ];
    }
}
