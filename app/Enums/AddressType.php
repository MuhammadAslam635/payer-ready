<?php

namespace App\Enums;

enum AddressType: string
{
    case HOME = 'home';
    case PRACTICE = 'practice';
    case BILLING = 'billing';
    case MAILING = 'mailing';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::HOME => 'Home Address',
            self::PRACTICE => 'Practice Address',
            self::BILLING => 'Billing Address',
            self::MAILING => 'Mailing Address',
            self::OTHER => 'Other',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
    public static function cssClass(): array{
        return [
            self::HOME->value => 'bg-green-500 text-white',
            self::PRACTICE->value => 'bg-cyan-500 text-white',
            self::BILLING->value => 'bg-yellow-500 text-white',
            self::MAILING->value => 'bg-teal-500 text-white',
            self::OTHER->value => 'bg-indigo-500 text-white',
        ];
    }
}
