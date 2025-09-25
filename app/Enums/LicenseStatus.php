<?php

namespace App\Enums;

enum LicenseStatus: string
{
    case PENDING = 'pending';
    case REQUESTED = 'requested';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case SUSPENDED = 'suspended';
    case REVOKED = 'revoked';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::REQUESTED => 'Requested',
            self::ACTIVE => 'Active',
            self::EXPIRED => 'Expired',
            self::SUSPENDED => 'Suspended',
            self::REVOKED => 'Revoked',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
