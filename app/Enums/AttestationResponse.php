<?php

namespace App\Enums;

enum AttestationResponse: string
{
    case YES = 'Yes';
    case NO = 'No';
    case NA = 'N/A';

    public function label(): string
    {
        return match($this) {
            self::YES => 'Yes',
            self::NO => 'No',
            self::NA => 'N/A',
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
            self::YES->value => 'bg-green-500 text-white',
            self::NO->value => 'bg-red-500 text-white',
            self::NA->value => 'bg-gray-500 text-white',
        ];
    }
}
