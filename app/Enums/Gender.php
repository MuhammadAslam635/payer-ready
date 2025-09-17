<?php

namespace App\Enums;

enum Gender: string
{
    case MALE = 'M';
    case FEMALE = 'F';
    case OTHER = 'Other';
    case PREFER_NOT_TO_SAY = 'Prefer not to say';

    public function label(): string
    {
        return match($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
            self::OTHER => 'Other',
            self::PREFER_NOT_TO_SAY => 'Prefer not to say',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
