<?php

namespace App\Enums;

enum CredentialStatus: string
{
    //
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case SUSPENDED = 'suspended';
    case REVOKED = 'revoked';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::EXPIRED => 'Expired',
            self::SUSPENDED => 'Suspended',
            self::REVOKED => 'Revoked',
        };
    }
    public static function options(): array
    {
            return [
                self::ACTIVE->value => self::label(self::ACTIVE),
                self::EXPIRED->value => self::label(self::EXPIRED),
                self::SUSPENDED->value => self::label(self::SUSPENDED),
                self::REVOKED->value => self::label(self::REVOKED),
            ];
    }
}
